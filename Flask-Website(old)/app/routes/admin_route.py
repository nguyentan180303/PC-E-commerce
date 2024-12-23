#app/admin/routes/admin_route.py
from flask import Blueprint, render_template, redirect, url_for, flash, request, session
from sqlalchemy import func
from app import db
from flask_login import login_required, current_user, logout_user
from app.models import Admin, Cart, Client, Product, Category, Order, OrderProducts, Delivery, LoyalClient, Catalog, DeliveryType, Address, Review, Wish
from datetime import datetime
from werkzeug.utils import secure_filename
import os

admin_bp = Blueprint('admin', __name__)

@admin_bp.route('/dashboard')
@login_required
def dashboard():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    # Fetch the 10 most recent orders with delivery details
    recent_orders = db.session.query(Order, Delivery, Address).outerjoin(Delivery, Order.idOrder == Delivery.idOrder).outerjoin(Address, Delivery.idAddress == Address.idAddress).order_by(Order.date_order.desc()).limit(10).all()
    
    # Fetch related client and product data
    orders_with_details = []
    for order, delivery, address in recent_orders:
        client = Client.query.get(order.idClient)
        order_products = OrderProducts.query.filter_by(idOrder=order.idOrder).all()
        
        products = []
        for order_product in order_products:
            product = Product.query.get(order_product.idProduct)
            products.append({
                'name': product.name_prod,
                'quantity': order_product.quantity
            })
        
        orders_with_details.append({
            'order_id': order.idOrder,
            'customer_name': f"{client.firstName} {client.lastName}",
            'products': products,
            'amount': order.total_order,
            'order_date': order.date_order,
            'delivery_status': 'Completed' if delivery.status_del == 1 else 'Pending',
            'delivery_date': delivery.date_del if delivery.date_del else 'N/A',
            'delivery_id': delivery.idDelivery if delivery else 'N/A',
            'delivery_address': f"{address.details}, {address.city}, {address.country}, {address.zipCode}" if address else 'N/A',
            'delivery_type': order.id_deliveryType
        })
    
    # Fetch statistics
    total_sales = db.session.query(func.sum(Order.total_order)).scalar() or 0
    total_orders = Order.query.count()
    total_customers = Client.query.count()
    total_stocks = db.session.query(func.sum(Product.stock)).scalar() or 0  # Sum of all product quantities

    return render_template('admin_dashboard.html', 
                           recent_orders=orders_with_details,
                           total_sales=total_sales,
                           total_orders=total_orders,
                           total_customers=total_customers,
                           total_stocks=total_stocks)

@admin_bp.route('/customers')
@login_required
def customers():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    clients = Client.query.all()  # Fetch all clients from the database
    loyal_clients = [loyal_client.idClient for loyal_client in LoyalClient.query.all()]  # Fetch all loyal clients
    return render_template('admin_customers.html', clients=clients, loyal_clients=loyal_clients)

@admin_bp.route('/delete_customer/<int:client_id>', methods=['POST'])
@login_required
def delete_customer(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    print(f"Attempting to delete client with ID: {client_id}")  # Debug statement
    
    client = Client.query.get(client_id)
    if client:
        try:
            # Delete related orders and their associated records
            orders = Order.query.filter_by(idClient=client_id).all()
            for order in orders:
                OrderProducts.query.filter_by(idOrder=order.idOrder).delete()
                Delivery.query.filter_by(idOrder=order.idOrder).delete()
                db.session.delete(order)
            
            # Delete related deliveries
            deliveries = Delivery.query.filter(Delivery.idAddress.in_(
                db.session.query(Address.idAddress).filter_by(idClient=client_id)
            )).all()
            for delivery in deliveries:
                db.session.delete(delivery)
            
            # Delete related addresses
            addresses = Address.query.filter_by(idClient=client_id).all()
            for address in addresses:
                Delivery.query.filter_by(idAddress=address.idAddress).delete()
                db.session.delete(address)
            
            # Delete related loyal client records
            LoyalClient.query.filter_by(idClient=client_id).delete()
            # Delete related cart records
            Cart.query.filter_by(idClient=client_id).delete()
            # Delete related wish records
            Wish.query.filter_by(idClient=client_id).delete()
            # Delete related review records
            Review.query.filter_by(idClient=client_id).delete()
            
            # Finally, delete the client
            db.session.delete(client)
            db.session.commit()
            flash('Customer has been deleted successfully.', 'success')
        except Exception as e:
            db.session.rollback()
            print(f"Error deleting client: {e}")  # Debug statement
            flash('An error occurred while deleting the customer.', 'error')
    else:
        flash('Customer not found.', 'error')
    
    return redirect(url_for('admin.customers'))

@admin_bp.route('/verify_loyal_client/<int:client_id>', methods=['POST'])
@login_required
def verify_loyal_client(client_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    client = Client.query.get(client_id)
    if client:
        loyal_client = LoyalClient.query.filter_by(idClient=client_id).first()
        if loyal_client:
            db.session.delete(loyal_client)
            flash('Client has been removed from loyal clients.', 'success')
        else:
            new_loyal_client = LoyalClient(idClient=client_id)
            db.session.add(new_loyal_client)
            flash('Client has been verified as a loyal client.', 'success')
        db.session.commit()
    else:
        flash('Client not found.', 'error')
    return redirect(url_for('admin.customers'))

@admin_bp.route('/add_admin', methods=['GET', 'POST'])
@login_required
def registration():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    if request.method == 'POST':
        first_name = request.form.get('firstName')
        last_name = request.form.get('lastName')
        email = request.form.get('email')
        password = request.form.get('password')
        
        # Check if the email already exists
        existing_admin = Admin.query.filter_by(email=email).first()
        if existing_admin:
            flash('Email already registered.', 'error')
            return redirect(url_for('admin.registration'))
        
        # Create a new admin with plain text password (not recommended)
        new_admin = Admin(
            firstName=first_name,
            lastName=last_name,
            email=email,
            password=password
        )
        db.session.add(new_admin)
        db.session.commit()
        flash('Admin registered successfully.', 'success')
        return redirect(url_for('admin.registration'))
    
    admins = Admin.query.all()  # Fetch all admins from the database
    return render_template('admin_registration.html', admins=admins)

@admin_bp.route('/categories')
@login_required
def categories():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    categories = Category.query.all()  # Fetch all categories from the database
    catalogs = Catalog.query.all()  # Fetch all catalogs from the database
    return render_template('admin_categories.html', categories=categories, catalogs=catalogs)

@admin_bp.route('/add_category', methods=['POST'])
@login_required
def add_category():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    category_name = request.form.get('category_name')
    catalog_id = request.form.get('catalog_id')
    
    # Check if the category already exists
    existing_category = Category.query.filter_by(description_cat=category_name, idCatalog=catalog_id).first()
    if existing_category:
        flash('Category already exists.', 'error')
        return redirect(url_for('admin.categories'))
    
    if category_name and catalog_id:
        new_category = Category(description_cat=category_name, idCatalog=catalog_id)
        db.session.add(new_category)
        db.session.commit()
        flash('Category added successfully.', 'success')
    else:
        flash('Category name and catalog must be selected.', 'error')
    
    return redirect(url_for('admin.categories'))

@admin_bp.route('/edit_category/<int:category_id>', methods=['POST'])
@login_required
def edit_category(category_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    category = Category.query.get(category_id)
    if category:
        category_name = request.form.get('category_name')
        catalog_id = request.form.get('catalog_id')
        if category_name and catalog_id:
            category.description_cat = category_name
            category.idCatalog = catalog_id
            db.session.commit()
            flash('Category updated successfully.', 'success')
        else:
            flash('Category name and catalog must be selected.', 'error')
    else:
        flash('Category not found.', 'error')
    
    return redirect(url_for('admin.categories'))

@admin_bp.route('/delete_category/<int:category_id>', methods=['POST'])
@login_required
def delete_category(category_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    category = Category.query.get(category_id)
    if category:
        db.session.delete(category)
        db.session.commit()
        flash('Category has been deleted successfully.', 'success')
    else:
        flash('Category not found.', 'error')
    return redirect(url_for('admin.categories'))

@admin_bp.route('/products')
@login_required
def products():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    products = Product.query.all()  # Fetch all products from the database
    categories = Category.query.all() # Fetch all categories from the database
    return render_template('admin_products.html', products=products, categories=categories)

@admin_bp.route('/add_product', methods=['POST'])
@login_required
def add_product():
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    file = request.files['img_prod']
    if file and file.filename:
        filename = secure_filename(file.filename)
        file.save(os.path.join('app', 'static', 'img', filename))
        img_prod = filename
    else:
        img_prod = 'téléchargement.png'
    
    name_prod = request.form.get('name_prod')
    description_prod = request.form.get('description_prod')
    price = request.form.get('price')
    promo = request.form.get('promo')
    stock = request.form.get('stock')
    idCategory = request.form.get('idCategory')
    brand = request.form.get('brand')
    
    # Check if the product already exists
    existing_product = Product.query.filter_by(name_prod=name_prod, idCategory=idCategory, brand=brand).first()
    if existing_product:
        flash('Product already exists.', 'error')
        return redirect(url_for('admin.products'))
    
    if name_prod and description_prod and price and img_prod and stock and idCategory and brand:
        new_product = Product(
            name_prod=name_prod,
            description_prod=description_prod,
            price=price,
            img_prod=img_prod,
            promo=promo,
            stock=stock,
            idCategory=idCategory,
            brand=brand
        )
        db.session.add(new_product)
        db.session.commit()
        flash('Product added successfully.', 'success')
    else:
        flash('All fields must be filled.', 'error')
    
    return redirect(url_for('admin.products'))

@admin_bp.route('/edit_product/<int:product_id>', methods=['POST'])
@login_required
def edit_product(product_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    product = Product.query.get(product_id)
    if product:
        file = request.files['img_prod']
        if file and file.filename:
            filename = secure_filename(file.filename)
            file.save(os.path.join('app', 'static', 'img', filename))
            product.img_prod = filename

        product.name_prod = request.form.get('name_prod')
        product.description_prod = request.form.get('description_prod')
        product.price = request.form.get('price')
        product.promo = request.form.get('promo')
        product.stock = request.form.get('stock')
        product.idCategory = request.form.get('idCategory')
        product.brand = request.form.get('brand')
        
        if product.name_prod and product.description_prod and product.price and product.stock and product.idCategory and product.brand:
            db.session.commit()
            flash('Product updated successfully.', 'success')
        else:
            flash('All fields must be filled.', 'error')
    else:
        flash('Product not found.', 'error')
    
    return redirect(url_for('admin.products'))


@admin_bp.route('/delete_product/<int:product_id>', methods=['POST'])
@login_required
def delete_product(product_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    product = Product.query.get(product_id)
    if product:
        db.session.delete(product)
        db.session.commit()
        flash('Product has been deleted successfully.', 'success')
    else:
        flash('Product not found.', 'error')
    return redirect(url_for('admin.products'))

@admin_bp.route('/update_delivery_status/<int:order_id>', methods=['POST'])
@login_required
def update_delivery_status(order_id):
    if not isinstance(current_user, Admin):
        return redirect(url_for('main.home'))
    
    delivery = Delivery.query.filter_by(idOrder=order_id).first()
    if delivery:
        delivery.status_del = 1  # Assuming 1 means 'Completed'
        delivery.date_del = datetime.now()
        db.session.commit()
        return '', 204  # No Content response to indicate success
    else:
        return 'Delivery not found', 404

@admin_bp.route('/logout')
@login_required
def logout():
    logout_user()
    session.clear()
    return redirect(url_for('main.home'))
