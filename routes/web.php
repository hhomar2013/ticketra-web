<?php

use App\Livewire\It\TicketCreate;
use App\Livewire\It\TicketIndex;
use App\Livewire\It\TicketShow;
use App\Livewire\UserManager;
use App\Livewire\V1\Admin\DashboardIndex;
use App\Livewire\V1\Hardware\AssetCategories\AssetCategoriesCreate;
use App\Livewire\V1\Hardware\AssetCategories\AssetCategoriesIndex;
use App\Livewire\V1\Hardware\Assets\AssetReport;
use App\Livewire\V1\Hardware\Assets\AssetsCreate;
use App\Livewire\V1\Hardware\Assets\AssetsHistory;
use App\Livewire\V1\Hardware\Assets\AssetsIndex;
use App\Livewire\V1\Hardware\Assets\AssignToEmployee;
use App\Livewire\V1\Hardware\Assets\OnlineAssets;
use App\Livewire\V1\Hardware\Assets\ShowOnlineAsset;
use App\Livewire\V1\Hardware\Branch\BranchCreate;
use App\Livewire\V1\Hardware\Branch\BranchIndex;
use App\Livewire\V1\Hardware\Brands\BrandsCreate;
use App\Livewire\V1\Hardware\Brands\BrandsIndex;
use App\Livewire\V1\Hardware\Brands\BrandsModels;
use App\Livewire\V1\Invoices\InvoiceBatches;
use App\Livewire\V1\Invoices\InvoiceCreate as InvoicesInvoiceCreate;
use App\Livewire\V1\Invoices\InvoicesIndex;
use App\Livewire\V1\Maintenance\InvoiceCreate;
use App\Livewire\V1\Maintenance\InvoiceIndex;
use App\Livewire\V1\Reports\Feedback\FeedbackIndex;
use App\Livewire\V1\Settings\ConfigIndex;
use App\Livewire\V1\UsersManagement\UsersCreate;
use App\Livewire\V1\UsersManagement\UsersIndex;
use App\Livewire\V1\UsersManagement\UsersRoleAndPermissions;
use App\Livewire\V1\Users\UserDashboardIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->hasRole('it')) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('admin.dashboard');
    Route::get('it/tickets', TicketIndex::class)->name('it.tickets.index');
    Route::get('it/tickets/create', TicketCreate::class)->name('it.tickets.create');
    Route::get('/tickets/{id}', TicketShow::class)->name('it.tickets.show');
    Route::get('admin/users', UserManager::class)->name('admin.users');
    Route::view('profile', 'profile')->name('profile');
    Route::get('hardware/branches', BranchIndex::class)->name('hardware.branches');
    Route::get('hardware/branches/create', BranchCreate::class)->name('hardware.branches.create');
    Route::get('hardware/branches/edit/{id}', BranchCreate::class)->name('hardware.branches.edit');
    Route::get('hardware/asset-categories', AssetCategoriesIndex::class)->name('hardware.asset-categories');
    Route::get('hardware/asset-categories/create', AssetCategoriesCreate::class)->name('hardware.asset-categories.create');
    Route::get('hardware/asset-categories/edit/{id}', AssetCategoriesCreate::class)->name('hardware.asset-categories.edit');

    Route::get('hardware/brands', BrandsIndex::class)->name('hardware.brands');
    Route::get('hardware/brands/create', BrandsCreate::class)->name('hardware.brands.create');
    Route::get('hardware/brands/edit/{id}', BrandsCreate::class)->name('hardware.brands.edit');
    Route::get('hardware/brands/models/{id}', BrandsModels::class)->name('hardware.brands.models');

    Route::get('hardware/assets', AssetsIndex::class)->name('hardware.assets.index');
    Route::prefix('hardware/assets-online')->name('hardware.assets-online.')->group(function () {
        Route::get('/', OnlineAssets::class)->name('index');
        Route::get('/{id}', ShowOnlineAsset::class)->name('show');
    });//agent traking assets
    Route::get('hardware/assets/create/', AssetsCreate::class)->name('hardware.assets.create');
    Route::get('hardware/assets/edit/{id}', AssetsCreate::class)->name('hardware.assets.edit');
    Route::get('hardware/assets/history/{id}', AssetsHistory::class)->name('hardware.assets.history');
    Route::get('hardware/assets/assign-to-employee/{id}', AssignToEmployee::class)->name('hardware.assets.assign-to-employee');
    Route::get('maintenance/invoices', InvoiceIndex::class)->name('maintenance.invoices.index');
    Route::get('maintenance/invoices/create-maintenance-order', InvoiceCreate::class)->name('maintenance.invoices.create');

    Route::get('/reporsts/feedback', FeedbackIndex::class)->name('it.reports.feedback');
    // settings routes
    Route::get('settings/config', ConfigIndex::class)->name('settings.config');

    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::get('/', UsersIndex::class)->name('index');
        Route::get('/create', UsersCreate::class)->name('create');
        Route::get('/edit/{id}', UsersCreate::class)->name('edit');
        Route::get('/roles', UsersRoleAndPermissions::class)->name('roles');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', InvoicesIndex::class)->name('index');
        Route::get('/create', InvoicesInvoiceCreate::class)->name('create');
        Route::get('/edit/{id}', InvoicesInvoiceCreate::class)->name('edit');
        Route::get('/{id}/batches', InvoiceBatches::class)->name('batches');
    });

    Route::prefix('assets-reports')->name('assets-reports.')->group(function () {
        Route::get('/{id}', AssetReport::class)->name('index');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::get('/founders/dashboard', UserDashboardIndex::class)->name('user.dashboard');
    Route::get('it/tickets/create', TicketCreate::class)->name('tickets.create');
    // Route::get('/tickets/{id}', TicketShow::class)->name('tickets.show');
    Route::view('profile', 'profile')->name('profile');
});

Route::middleware('guest')->group(function () {
    Route::get('login', \App\Livewire\V1\Auth\Login::class)->name('login');
});

// require __DIR__ . '/auth.php';
