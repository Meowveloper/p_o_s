<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserManagementController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Rules\Role;
use App\Http\Controllers\User\ContactController as UserContactController;
use App\Http\Controllers\ContactController as AdminContactController;

/*TODO AuthController login, register */

Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');

    Route::get('loginPage', [AuthController::class, 'goToLoginPage'])->name('auth#goToLoginPage');

    Route::get('registerPage', [AuthController::class, 'goToRegisterPage'])->name('auth#goToRegisterPage');
});



/* ************************************** */


//TODO middleware
Route::middleware(['auth'])->group(function () {

    //TODO go to dashboard for both user and admin
    Route::get('dashboard', [AuthController::class, 'goToDashboard'])->name('auth#goToDashboard');

    // ********************************************

    //TODO admin_auth middleware
    Route::middleware(['admin_auth'])->group(function () {

        //TODO admin CategoryController
        Route::prefix('category')->group(function () {
            Route::get('categoryListPage', [CategoryController::class, 'goToCategoryListPage'])->name('category#goToCategoryListPage');

            //Creating a category
            Route::get('categoryCreatePage', [CategoryController::class, 'goToCategoryCreatePage'])->name('category#goToCategoryCreatePage');

            Route::post('createCategory', [CategoryController::class, 'createCategoty'])->name('category#createCategoty');
            //************************ */

            //Deleting a category
            Route::get('deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('category#deleteCategory');
            //*********************** */

            //Editing a Category
            Route::get('categoryEditPage/{id}', [CategoryController::class, 'goToCategoryEditPage'])->name('category#goToCategoryEditPage');

            Route::post('editCategory', [CategoryController::class, 'editCategory'])->name('category#editCategory');
            //************************* */
        });
        //*************CategoryController ends*************** */

        //TODO admin account (AdminController)
        Route::prefix('admin')->group(function () {

            //go to admin password change
            Route::get('account/passwordChangePage', [AdminController::class, 'goToAdminPasswordChangePage'])->name('admin#goToAdminPasswordChangePage');

            // admin change password
            Route::post('account/changePassword', [AdminController::class, 'changePassword'])->name('admin#changePassword');

            //go to admin account details page
            Route::get('account/detailsPage', [AdminController::class, 'goToAdminAccountDetailsPage'])->name('admin#goToAdminAccountDetailsPage');

            //go to admin account edit page
            Route::get('account/editPage', [AdminController::class, 'goToAdminAccountEditPage'])->name('admin#goToAdminAccountEditPage');

            //update admin account
            Route::post('account/update/{id}', [AdminController::class, 'updateAdminAccount'])->name('admin#updateAdminAccount');

            //go to admin accounts list page
            Route::get('accounts/listPage', [AdminController::class, 'goToAdminAccountsListPage'])->name('admin#goToAdminAccountsListPage');

            //delete an admin account
            Route::get('account/delete/{id}', [AdminController::class, 'deleteAnAdminAccount'])->name('admin#deleteAnAdminAccount');

            //go to change role page
            Route::get('account/changeRolePage/{id}', [AdminController::class, 'goToChangeRolePage'])->name('admin#goToChangeRolePage');


            Route::post('account/changeRole/{id}', [AdminController::class, 'changeARole'])->name('admin#changeARole');

            //TODO admin/userManagement
            Route::prefix('userManagement')->group(function () {
                Route::get('listPage', [UserManagementController::class, 'goToUserListPage'])->name('admin#userManagement#goToListPage');
                Route::get('changeUserRole', [UserManagementController::class, 'changeUserRole']);

                Route::get('userUpdatePage/{id}', [UserManagementController::class, 'goToUserUpdatePage'])->name('admin#userManagement#goToUserUpdatePage');

                Route::post('updateUser', [UserManagementController::class, 'updateUser'])->name('admin#userManagement#updateUser');

                Route::get('deleteUser/{id}', [UserManagementController::class, 'deleteUser'])->name('admin#userManagement#deleteUser');
            });
        });

        //TODO admin products (ProductController)
        Route::prefix('product')->group(function () {

            //go to product listPage
            Route::get('listPage', [ProductController::class, 'goToListPage'])->name('product#goToListPage');

            //go to product createPage
            Route::get('createPage', [ProductController::class, 'goToCreatePage'])->name('product#goToCreatePage');

            //createProduct
            Route::post('create', [ProductController::class, 'createProduct'])->name('product#createProduct');

            //delete a product
            Route::get('delete/{id}', [ProductController::class, 'deleteProduct'])->name('product#deleteProduct');

            //go to product details page
            Route::get('detailsPage/{id}', [ProductController::class, 'goToDetailsPage'])->name('product#goToDetailsPage');


            //go to product edit page
            Route::get('editPage/{id}', [ProductController::class, 'goToEditPage'])->name('product#goToEditPage');

            Route::post('edit', [ProductController::class, 'editProduct'])->name('product#editProduct');
        });



        //TODO admin/orders
        Route::prefix('admin/order')->group(function () {
            Route::get('listPage', [OrderController::class, 'goToListPage'])->name('admin#order#goToListPage');

            Route::get('filterByStatus', [OrderController::class, 'filterByStatus']);

            Route::get('changeStatusInTheDataBase', [OrderController::class, 'changeStatusInTheDataBase']);

            Route::get('detailsPage/{orderCode}', [OrderController::class, 'goToOrderDetailsPage'])->name('admin#order#goToDetailsPage');
        });

        //TODO admin/contact
        Route::prefix('admin/contact')->group(function() {
            Route::get('listPage', [AdminContactController::class, 'goToListPage'])->name('admin#contact#goToListPage');
        });
    });
    //****************admin_auth ends*********************** */



    //TODO UserController user->go to category page **user**

    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::redirect('/', 'user/homePage');

        //TODO go to user/homePage
        Route::get('homePage', [UserController::class, 'goToHomePage'])->name('user#goToHomePage');

        //TODO user/homePage filter by categories
        Route::prefix('filter')->group(function () {
            Route::get('byCategory/{id}', [UserController::class, 'filterByCategories'])->name('user#filter#byCategories');
        });


        //TODO user/password
        Route::prefix('password')->group(function () {

            //go to password change page
            Route::get('changePage', [UserController::class, 'goToPasswordChangePage'])->name('user#goToPasswordChangePage');

            // change the password
            Route::post('change', [UserController::class, 'changePassword'])->name('user#changePassword');
        });

        //TODO user/account
        Route::prefix('account')->group(function () {

            //go to details page
            Route::get('detailsPage', [UserController::class, 'goToDetailsPage'])->name('user#account#goToDetailsPage');

            //go to edit page
            Route::get('editPage', [UserController::class, 'goToEditPage'])->name('user#account#goToEditPage');

            // edit account details
            Route::post('editAccount/{id}', [UserController::class, 'editAccount'])->name('user#account#editAccount');
        });


        //TODO user/ajax
        Route::prefix('ajax')->group(function () {

            //returning the product list to the JS
            Route::get('productList', [AjaxController::class, 'returnProductList'])->name('user/ajax#returnProductList');

            //add a product to cart
            Route::get('addToCart', [AjaxController::class, 'addToCart'])->name('user#ajax#addToCart');

            //remove a product from cart
            Route::get('removeAProductFromCart', [AjaxController::class, 'removeAProductFromCart'])->name('user#ajax#removeAProductFromCart');

            //check out or make an order
            Route::get('checkOut', [AjaxController::class, 'checkOut'])->name('user#ajax#checkOut');

            //clear cart
            Route::get('clearCart', [AjaxController::class, 'clearCart'])->name('user#ajax#clearCart');

            //increase view count
            Route::get('increaseViewCount', [AjaxController::class, 'increaseViewCount'])->name('user#ajax#increaseViewCount');
        });

        //TODO user/product
        Route::prefix('product')->group(function () {

            //go to user/productDetailsPage
            Route::get('detailsPage/{id}', [UserController::class, 'goToProductDetailsPage'])->name('user#product#goToDetailsPage');
        });

        //TODO user/cart
        Route::prefix('cart')->group(function () {
            Route::get('cartPage', [UserController::class, 'goToCartPage'])->name('user#cart#goToCartPage');
        });


        //TODO user/order
        Route::prefix('order')->group(function () {
            Route::get('historyPage', [UserController::class, 'goToOrderHistoryPage'])->name('user#order#goToHistoryPage');
        });

        //TODO user/contact
        Route::prefix('contact')->group(function () {

            //go to contact create page
            Route::get('createPage', [UserContactController::class, 'goToContactCreatePage'])->name('user#contact#goToCreatePage');

            Route::post('create', [UserContactController::class, 'createContact'])->name('user#contact#create');
        });
    });

    //****************************************** */

});

Route::get('webTesting', function () {
    $data = [
        'message' => 'this is testing message'
    ];
    return response()->json($data, 200);
});
