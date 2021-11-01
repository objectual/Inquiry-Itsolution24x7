<p align="center"><img src="http://www.itsolution24x7.com/images/logo.png"></p>

## InfyOm Generator Builder with ACL

Create Laravel Applications with Admin Panel and ACL in minutes with InfyOm and our Generator Builder. 

## Whats used?

- **PHP 7.1** 
- **Laravel 5.6**
- InfyOm Laravel Generator
- AdminLTE Theme
- Swagger Generator from InfyOm
- DataTables
- Entrust (ACL)
- Repository Pattern

## Installation
- git clone "https://github.com/ArsalanSaleem94/itsol_request_form.git"
- Update Composer "composer update"
- Edit .env file according to your DB credentials.
- Rum Migration and Seeder "php artisan migrate:refresh --seed"

## How To?
**Step 1**
- Make Schema Architecture in Mysql.
- Select Module Right there in side menu
- Select Table.
- Enter Module Name
- Next

**Step 2**
- Enter fields for listing tables.
- Width -> Col Width in %.
 
**Step 3**
- Enter fields for forms. {Add / Edit}
- Type -> HTML input type.
- Validation -> laravel validations.
- Width -> Bootstrap Columns.


**Check Generated Files:**
- Check Controller, Model, View, Request, Repositories

## Admin Credentials are here:
- Super admin (development admin)

    - 'email'    => "superadmin@itsolution.com"
    - 'password' => 'superadmin123'
- Admin
    - 'email'    => "admin@itsolution.com"
    - 'password' => 'admin123'
     
## update vendor file for swagger
- update root -> vendor/jlapp/swaggervel/src/Jlapp/Swaggervel/routes.php line# 51,52 comment both lines

## Want to use Searchable Dropdown?
- Add class "select2" to your dropdown.

## Ask SW confirmation before delete?
- Call function "confirmDelete()" on Onclick event.

## Want to add add fields from another related table in datatables?
- In datatable.php use this in dataTable method : $query = $query->with(['relation_name']);

## Want to add Translatable module?
- please see Page Module For Reference.

## Make dependent dropdowns is fun now.!!
- Use class="select2" and data-url="route_to_fetch_data" data-depends="parent_name"


**_Build Something Amazing_**
