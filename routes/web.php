<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/api/visitor-stats', [DashboardController::class, 'getVisitorStats']);
Route::get('/api/active-visitors', [DashboardController::class, 'getActiveVisitors']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes for pendaftaran management
    Route::get('/admin/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/admin/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/admin/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/admin/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::get('/admin/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
    Route::put('/admin/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
    Route::delete('/admin/pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
    Route::get('/admin/pendaftaran/{id}/payment-proof', [PendaftaranController::class, 'viewPaymentProof'])->name('pendaftaran.viewPaymentProof');
    // New route for verifying installment payments
    Route::get('/admin/pendaftaran/{id}/installments', [PendaftaranController::class, 'viewInstallments'])->name('pendaftaran.viewInstallments');
    Route::post('/admin/pendaftaran/verify-installment/{installmentId}', [PendaftaranController::class, 'verifyInstallment'])->name('pendaftaran.verifyInstallment');
});

Route::get('/profil', function () {
    return view('profil');
});

//Student Route
// Resource routes for standard CRUD operations
Route::resource('/admin/student', StudentController::class)->middleware('auth')->names('student');

// Updated Student Export and Import routes
Route::get('/admin/student-export', [StudentController::class, 'export'])->name('student.export')->middleware('auth');
Route::get('/admin/student-import', [StudentController::class, 'importForm'])->name('student.import.form')->middleware('auth');
Route::post('/admin/student-import', [StudentController::class, 'import'])->name('student.import')->middleware('auth');
Route::get('/admin/student-template', [StudentController::class, 'template'])->name('student.template')->middleware('auth');
Route::get('/admin/student-search', [StudentController::class, 'search'])->name('student.search')->middleware('auth');

// Public routes for pendaftaran (updated for single-page flow)
Route::get('/pendaftaran', [PendaftaranController::class, 'halamandepan'])->name('pendaftaran.halamandepan');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::post('/pendaftaran/checking', [PendaftaranController::class, 'checking'])->name('pendaftaran.checking');
Route::post('/pendaftaran/pembayaran', [PendaftaranController::class, 'pembayaran'])->name('pendaftaran.pembayaran');
Route::get('/pendaftaran/pembayaran', [PendaftaranController::class, 'showPembayaran'])->name('pendaftaran.showPembayaran');
Route::get('/pendaftaran/berhasil', [PendaftaranController::class, 'berhasil'])->name('pendaftaran.berhasil');
Route::get('/pendaftaran/{calonSantri}/download-payment-proof', [PendaftaranController::class, 'downloadPaymentProof'])->name('pendaftaran.downloadPaymentProof');
Route::post('/pendaftaran/track', [PendaftaranController::class, 'trackPendaftaran'])->name('pendaftaran.track');
Route::post('/pendaftaran/uploadInstallment/{calonSantri}', [PendaftaranController::class, 'uploadInstallment'])->name('pendaftaran.uploadInstallment');
Route::post('/pendaftaran/upload-installment', [PendaftaranController::class, 'uploadInstallmentPublic'])->name('pendaftaran.uploadInstallmentPublic');
Route::post('/update-session', [PendaftaranController::class, 'updateSession'])->name('update.session');
Route::get('/pendaftaran/reset', [PendaftaranController::class, 'resetPendaftaran'])->name('pendaftaran.reset');

//Gallery Route
Route::get('/gallery/video', [GalleryController::class, 'galleryVideo'])->name('gallery.videos');
Route::get('/gallery/photo', [GalleryController::class, 'galleryPhoto'])->name('galleries.photo');
Route::delete('/dashboard/galeri/mass-destroy', [GalleryController::class, 'massDestroy'])->name('galeri.massDestroy');
Route::resource('dashboard/galeri', GalleryController::class);

//Article Route
Route::resource('articles', ArticleController::class)->except(['show'])->middleware(['auth']);
// Update the routes for the new structure
Route::get('/articles/{category:slug}/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/all-article', [ArticleController::class, 'allArticles'])->name('all-articles');
Route::get('/articles/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/analytics/article/{id}', [ArticleController::class, 'analytics'])
    ->name('articles.analytics')
    ->middleware('auth');

// Category routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

//User Route
// Add these routes for real-time status updates
Route::get('/teachers/check-status', [UserController::class, 'checkStatus'])->name('teachers.check-status');
Route::post('/teachers/update-activity', [UserController::class, 'updateActivity'])->name('teachers.update-activity');
Route::resource('teachers', UserController::class)->middleware('auth');

// Comment routes
Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::post('comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

// Add this route for real-time like updates
Route::get('/comments/likes', function (Illuminate\Http\Request $request) {
    $commentIds = explode(',', $request->query('ids', ''));
    $likes = [];

    if (!empty($commentIds)) {
        $comments = \App\Models\Comment::whereIn('id', $commentIds)->get(['id', 'likes_count']);
        foreach ($comments as $comment) {
            $likes[$comment->id] = $comment->likes_count;
        }
    }

    return response()->json(['likes' => $likes]);
})->name('comments.likes');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

require __DIR__ . '/auth.php';
