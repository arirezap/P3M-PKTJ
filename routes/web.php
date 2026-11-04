<?php

use App\Http\Controllers\Admin\CollaborationController as AdminCollaborationController;
use App\Http\Controllers\Admin\CommunityServiceController as AdminCommunityServiceController;
use App\Http\Controllers\Admin\CommunityServiceOutputController as AdminCommunityServiceOutputController;
use App\Http\Controllers\Admin\CommunityServiceProposalController as AdminCommunityServiceProposalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\OrganizationController as AdminOrganizationController;
use App\Http\Controllers\Admin\OutputController as AdminOutputController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Admin\ResearchController as AdminResearchController;
use App\Http\Controllers\Admin\ResearchProposalController as AdminResearchProposalController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ProposalController as DosenProposalController;
use App\Http\Controllers\Dosen\MonevController as DosenMonevController;
use App\Http\Controllers\Dosen\FinalReportController as DosenFinalReportController;
use App\Http\Controllers\Reviewer\DashboardController as ReviewerDashboardController;
use App\Http\Controllers\Reviewer\ProposalReviewController as ReviewerProposalReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicCollaborationController;
use App\Http\Controllers\PublicCommunityServiceCollaborationController;
use App\Http\Controllers\PublicCommunityServiceController;
use App\Http\Controllers\PublicCommunityServiceOutputController;
use App\Http\Controllers\PublicGuidelineController;
use App\Http\Controllers\PublicOutputController;
use App\Http\Controllers\PublicResearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Publik P3M PKTJ
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('beranda');

// Halaman Publik Profil
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/rencana-strategis', [ProfileController::class, 'rencanaStrategis'])->name('rencana-strategis');
    Route::get('/roadmap-penelitian', [ProfileController::class, 'roadmapPenelitian'])->name('roadmap-penelitian');
    Route::get('/visi-misi', [ProfileController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/peneliti', [ProfileController::class, 'peneliti'])->name('peneliti');
    Route::get('/sdm', [ProfileController::class, 'sdm'])->name('sdm');
});

// Halaman Publik Riset (Kegiatan Penelitian, Luaran Penelitian & Kerjasama)
Route::prefix('riset')->name('riset.')->group(function () {
    Route::get('/penelitian', [PublicResearchController::class, 'index'])->name('penelitian');
    Route::get('/penelitian/{research}/unduh', [PublicResearchController::class, 'downloadReport'])->name('penelitian.unduh');
    Route::get('/luaran', [PublicOutputController::class, 'index'])->name('luaran');
    Route::get('/luaran/{output}/unduh', [PublicOutputController::class, 'downloadFile'])->name('luaran.unduh');
    Route::get('/kerjasama', [PublicCollaborationController::class, 'index'])->name('kerjasama');
    Route::get('/kerjasama/{collaboration}/unduh', [PublicCollaborationController::class, 'downloadDocument'])->name('kerjasama.unduh');
});

// Halaman Publik Pengabdian kepada Masyarakat (PkM)
Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('pengabdian.pkm');
    });
    Route::get('/pkm', [PublicCommunityServiceController::class, 'index'])->name('pkm');
    Route::get('/pkm/{communityService}/unduh', [PublicCommunityServiceController::class, 'downloadReport'])->name('pkm.unduh');
    Route::get('/luaran', [PublicCommunityServiceOutputController::class, 'index'])->name('luaran');
    Route::get('/luaran/{communityServiceOutput}/unduh', [PublicCommunityServiceOutputController::class, 'downloadFile'])->name('luaran.unduh');
    Route::get('/kerjasama', [PublicCommunityServiceCollaborationController::class, 'index'])->name('kerjasama');
    Route::get('/kerjasama/{collaboration}/unduh', [PublicCommunityServiceCollaborationController::class, 'downloadDocument'])->name('kerjasama.unduh');
});

// Halaman Publik Layanan (Panduan, Pedoman Mutu & SOP)
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('layanan.panduan-pedoman');
    });
    Route::get('/panduan-pedoman', [PublicGuidelineController::class, 'index'])->name('panduan-pedoman');
    Route::get('/sop', [PublicGuidelineController::class, 'sop'])->name('sop');
    Route::get('/panduan-pedoman/{document}/unduh', [PublicGuidelineController::class, 'download'])->name('panduan-pedoman.unduh');
});

// Unduh Dokumen Publik
Route::get('/dokumen/{document}/unduh', [ProfileController::class, 'downloadDocument'])->name('documents.download');

/*
|--------------------------------------------------------------------------
| Autentikasi SIM P3M
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:15,1')->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Portal Admin P3M (Panel CMS & Manajemen Riset/Pengabdian)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Home (Dasbor Utama Admin SIM P3M)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Sub-Menu 1: Modul Penelitian (Siklus Submission s.d. Archive & Penugasan Reviewer)
    Route::prefix('penelitian')->name('penelitian.')->group(function () {
        Route::get('/', [AdminResearchProposalController::class, 'index'])->name('index');
        Route::get('{proposal}/print', [AdminResearchProposalController::class, 'print'])->name('print');
        Route::post('{proposal}/assign-reviewer', [AdminResearchProposalController::class, 'assignReviewer'])->name('assign-reviewer');
        Route::patch('{proposal}/update-status', [AdminResearchProposalController::class, 'updateStatus'])->name('update-status');
        Route::post('{proposal}/archive', [AdminResearchProposalController::class, 'archive'])->name('archive');
    });

    // Sub-Menu 2: Modul Pengabdian kepada Masyarakat (Siklus Submission s.d. Archive & Penugasan Reviewer)
    Route::prefix('pengabdian-masyarakat')->name('pengabdian.')->group(function () {
        Route::get('/', [AdminCommunityServiceProposalController::class, 'index'])->name('index');
        Route::get('{proposal}/print', [AdminCommunityServiceProposalController::class, 'print'])->name('print');
        Route::post('{proposal}/assign-reviewer', [AdminCommunityServiceProposalController::class, 'assignReviewer'])->name('assign-reviewer');
        Route::patch('{proposal}/update-status', [AdminCommunityServiceProposalController::class, 'updateStatus'])->name('update-status');
        Route::post('{proposal}/archive', [AdminCommunityServiceProposalController::class, 'archive'])->name('archive');
    });

    // CMS Berita & Pengumuman
    Route::resource('posts', AdminPostController::class);

    // CMS Dokumen Regulasi & SOP
    Route::resource('documents', AdminDocumentController::class)->except(['show']);

    // CMS Data Riset per Prodi & Impor CSV
    Route::post('researches/import', [AdminResearchController::class, 'import'])->name('researches.import');
    Route::resource('researches', AdminResearchController::class)->except(['show']);

    // CMS Luaran Penelitian (Publikasi, HKI, Produk/Jasa)
    Route::resource('outputs', AdminOutputController::class)->except(['show']);

    // CMS Kerjasama Riset & Kemitraan
    Route::resource('collaborations', AdminCollaborationController::class)->except(['show']);

    // CMS Data Pengabdian (PkM) per Prodi & Impor CSV
    Route::post('community-services/import', [AdminCommunityServiceController::class, 'import'])->name('community-services.import');
    Route::resource('community-services', AdminCommunityServiceController::class)->except(['show']);

    // CMS Luaran Pengabdian kepada Masyarakat (PkM) & Impor CSV
    Route::post('community-service-outputs/import', [AdminCommunityServiceOutputController::class, 'import'])->name('community-service-outputs.import');
    Route::resource('community-service-outputs', AdminCommunityServiceOutputController::class)->except(['show']);

    // Manajemen Usulan Proposal & Penugasan Reviewer
    Route::get('proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
    Route::patch('proposals/{proposal}/status', [AdminProposalController::class, 'updateStatus'])->name('proposals.update-status');
    Route::post('proposals/{proposal}/assign-reviewer', [AdminProposalController::class, 'assignReviewer'])->name('proposals.assign-reviewer');

    // Manajemen Pengguna (Dosen & Reviewer)
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('users/{user}/roles', [AdminUserController::class, 'updateRoles'])->name('users.update-roles');
    Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    // CMS Pengaturan Beranda & Video Profil
    Route::get('settings/profile', [AdminSettingController::class, 'editProfile'])->name('settings.profile');
    Route::put('settings/profile', [AdminSettingController::class, 'updateProfile'])->name('settings.profile.update');

    // CMS Pengaturan Visi, Misi & Tujuan
    Route::get('settings/visi-misi', [AdminSettingController::class, 'editVisiMisi'])->name('settings.visi-misi');
    Route::put('settings/visi-misi', [AdminSettingController::class, 'updateVisiMisi'])->name('settings.visi-misi.update');

    // CMS Pengaturan Header (Navbar) & Footer
    Route::get('settings/header-footer', [AdminSettingController::class, 'editHeaderFooter'])->name('settings.header-footer');
    Route::put('settings/header-footer', [AdminSettingController::class, 'updateHeaderFooter'])->name('settings.header-footer.update');

    // CMS Struktur Organisasi & Sumber Daya Manusia (SDM)
    Route::get('organization', [AdminOrganizationController::class, 'index'])->name('organization.index');
    Route::put('organization/settings', [AdminOrganizationController::class, 'updateSettings'])->name('organization.settings.update');
    Route::post('organization/members', [AdminOrganizationController::class, 'storeMember'])->name('organization.members.store');
    Route::put('organization/members/{member}', [AdminOrganizationController::class, 'updateMember'])->name('organization.members.update');
    Route::delete('organization/members/{member}', [AdminOrganizationController::class, 'destroyMember'])->name('organization.members.destroy');
    Route::patch('organization/members/{member}/toggle-status', [AdminOrganizationController::class, 'toggleStatus'])->name('organization.members.toggle-status');
});

/*
|--------------------------------------------------------------------------
| Portal Dosen / Peneliti (Pengajuan Usulan & RAB)
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengajuan Usulan & RAB
    Route::resource('proposals', DosenProposalController::class)->except(['index']);
    Route::post('proposals/{proposal}/submit', [DosenProposalController::class, 'submit'])->name('proposals.submit');
    Route::post('proposals/{proposal}/revision', [DosenProposalController::class, 'uploadRevision'])->name('proposals.upload-revision');

    // Pemantauan & Evaluasi (Monev - PDF Hal. 10–12)
    Route::get('proposals/{proposal}/monev', [DosenMonevController::class, 'create'])->name('proposals.monev.create');
    Route::post('proposals/{proposal}/monev', [DosenMonevController::class, 'store'])->name('proposals.monev.store');
    Route::get('proposals/{proposal}/monev/detail', [DosenMonevController::class, 'show'])->name('proposals.monev.show');

    // Pelaporan Akhir Kegiatan (Laporan Akhir - PDF Hal. 13–14)
    Route::get('proposals/{proposal}/laporan-akhir', [DosenFinalReportController::class, 'create'])->name('proposals.final-report.create');
    Route::post('proposals/{proposal}/laporan-akhir', [DosenFinalReportController::class, 'store'])->name('proposals.final-report.store');
    Route::get('proposals/{proposal}/laporan-akhir/detail', [DosenFinalReportController::class, 'show'])->name('proposals.final-report.show');
    Route::post('proposals/{proposal}/laporan-akhir/revisi', [DosenFinalReportController::class, 'uploadRevision'])->name('proposals.final-report.revision');
});

/*
|--------------------------------------------------------------------------
| Portal Reviewer (Penilaian & Rekomendasi Usulan)
|--------------------------------------------------------------------------
*/
Route::prefix('reviewer')->middleware(['auth', 'role:reviewer'])->name('reviewer.')->group(function () {
    Route::get('/dashboard', [ReviewerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reviews/{review}', [ReviewerProposalReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{review}/agree', [ReviewerProposalReviewController::class, 'agreeReview'])->name('reviews.agree');
    Route::put('/reviews/{review}', [ReviewerProposalReviewController::class, 'update'])->name('reviews.update');

    // Penilaian Kemajuan Monev oleh Reviewer (PDF Hal. 17 & 19)
    Route::get('/reviews/{review}/monev', [ReviewerProposalReviewController::class, 'monevShow'])->name('reviews.monev.show');
    Route::put('/reviews/{review}/monev', [ReviewerProposalReviewController::class, 'monevUpdate'])->name('reviews.monev.update');

    // Penilaian Laporan Akhir oleh Reviewer (PDF Hal. 17 & 19)
    Route::get('/reviews/{review}/laporan-akhir', [ReviewerProposalReviewController::class, 'finalReportShow'])->name('reviews.final-report.show');
    Route::put('/reviews/{review}/laporan-akhir', [ReviewerProposalReviewController::class, 'finalReportUpdate'])->name('reviews.final-report.update');
});
