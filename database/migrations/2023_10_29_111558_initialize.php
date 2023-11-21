<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->string('country', 20)->nullable();
            $table->string('city', 30)->nullable();
            $table->char('postal_code', 6)->nullable();
            $table->string('street', 40)->nullable();
            $table->unsignedSmallInteger('building')->nullable();
            $table->unsignedSmallInteger('apartment')->nullable();

            $table->timestamps();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);

            $table->timestamps();
        });

        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);

            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->constrained();
            $table->foreignId('job_title_id')->constrained();
            $table->decimal('salary');

            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->char('pesel', 11);

            $table->foreignId('address_id')->constrained();
            $table->string('email_address', 50);
            $table->string('phone_number', 20);
            $table->char('account_number', 26);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 30)->nullable();
            $table->string('last_name', 30)->nullable();

            $table->foreignId('address_id')->constrained();
            $table->string('email_address', 50)->nullable();
            $table->string('phone_number', 20)->nullable();

            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('email_address', 40);
            $table->string('password', 255);
            $table->char('remember_token', 100)->nullable();
            $table->foreignId('customer_id')->constrained();

            $table->timestamps();

            $table->unique('email_address');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);
            $table->string('code', 10);
            $table->enum('grammatical_gender', ['M', 'F'])->nullable();
            $table->foreignId('supercategory_id')->nullable()->constrained('categories', 'id');

            $table->timestamps();
        });

        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);
            $table->foreignId('address_id')->constrained();
            $table->char('eu_tax_id', 12);

            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);
            $table->foreignId('address_id')->constrained();
            $table->char('eu_tax_id', 12);

            $table->timestamps();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->string('origin', 100);
            $table->string('name', 100);
            $table->boolean('thumbnail')->default(false);
            $table->morphs('resource');

            $table->timestamps();
        });

        // [x] add product reviews

        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->foreignId('manufacturer_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->double('price');
            $table->json('details');
            $table->unsignedTinyInteger('warranty_period');
            $table->unsignedInteger('number_in_stock');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->unsignedTinyInteger('rating');
            $table->text('content');

            $table->timestamps();
        });

        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code', 10);
            $table->unsignedTinyInteger('discount');
            $table->date('expires_at');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);
            $table->text('description');
            $table->date('expires_at');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_product', function (Blueprint $table) {
            $table->foreignId('sale_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->decimal('price');
        });

        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id')->constrained();

            $table->timestamps();
        });

        Schema::create('delivery_product', function (Blueprint $table) {
            $table->foreignId('delivery_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->unsignedInteger('quantity');
        });

        // [x] payment methods, shipping methods, shippers

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);

            $table->timestamps();
        });

        Schema::create('shippers', function (Blueprint $table) {
             $table->id();

            $table->string('name', 40);
            $table->char('eu_tax_id', 12);

            $table->timestamps();
        });

        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();

            $table->string('name', 40);
            $table->foreignId('shipper_id')->constrained();

            $table->unsignedTinyInteger('min_days');
            $table->unsignedTinyInteger('max_days');
            $table->decimal('fee', 4, 2);

            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
             $table->id();

            $table->decimal('total', 9, 2);
            $table->foreignId('discount_code_id')->nullable();

            $table->foreignId('customer_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();
            $table->foreignId('shipping_method_id')->constrained();
            $table->boolean('completed')->default(false);

            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->unsignedInteger('quantity')->default(1);
            $table->boolean('returned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('order_product');
        Schema::drop('orders');
        Schema::drop('shipping_methods');
        Schema::drop('shippers');
        Schema::drop('payment_methods');
        Schema::drop('delivery_product');
        Schema::drop('deliveries');
        Schema::drop('sale_product');
        Schema::drop('sales');
        Schema::drop('discount_codes');
        Schema::drop('product_reviews');
        Schema::drop('products');
        Schema::drop('suppliers');
        Schema::drop('manufacturers');
        Schema::drop('categories');
        Schema::drop('users');
        Schema::drop('customers');
        Schema::drop('employees');
        Schema::drop('job_titles');
        Schema::drop('departments');
        Schema::drop('addresses');
    }
};
