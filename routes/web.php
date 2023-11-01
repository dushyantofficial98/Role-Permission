<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return  redirect()->route('login');
//    return view('welcome');
});
//Auth::routes(['verify' => true]);

Route::get('clear_cache', function () {

    \Artisan::call('optimize:clear');
    return redirect()->back()->with("success","Cache is cleared");


});
\Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('test-mail', [App\Http\Controllers\HomeController::class, 'mail'])->name('test-mail');
Route::get('verify_email', [App\Http\Controllers\HomeController::class, 'verify_email'])->name('verify-email');

//Route::get('send-mail', [App\Http\Controllers\HomeController::class, 'send_mail'])->name('send-mail');

//New Route Clear
Route::get('register_page', [App\Http\Controllers\UserController::class, 'register_page'])->name('register-page');
Route::get('index', [App\Http\Controllers\UserController::class, 'index_page'])->name('index-page');
Route::get('/api/check-email', [App\Http\Controllers\API\EmailController::class,'checkEmail'])->name('check-email');
Route::get('test_register_page', [App\Http\Controllers\UserController::class, 'test_register_page'])->name('test-register-page');

//New Route
Route::get('table_index', [App\Http\Controllers\UserController::class, 'table_index'])->name('table-index');


Route::get('question_table', [App\Http\Controllers\UserController::class, 'question_table'])->name('question-table');
Route::get('question_create', [App\Http\Controllers\UserController::class, 'question_create'])->name('question-create');
Route::get('evaluation_criteria', [App\Http\Controllers\UserController::class, 'evaluation_criteria'])->name('evaluation-criteria');
Route::get('evaluation_criteria_create', [App\Http\Controllers\UserController::class, 'evaluation_criteria_create'])->name('evaluation-criteria-create');
Route::get('additional_evaluation_criteria', [App\Http\Controllers\UserController::class, 'additional_evaluation_criteria'])->name('additional-evaluation-criteria');
Route::get('additional_evaluation_criteria_create', [App\Http\Controllers\UserController::class, 'additional_evaluation_criteria_create'])->name('additional-evaluation-criteria-create');


Route::get('campaign-ideas-index', [App\Http\Controllers\UserController::class, 'campaign_ideas_index'])->name('campaign-ideas-index');
Route::get('sub-campaign-ideas-index', [App\Http\Controllers\UserController::class, 'sub_campaign_ideas_index'])->name('sub_campaign-ideas-index');
Route::get('test_question_create', [App\Http\Controllers\UserController::class, 'test_question_create'])->name('test-question-create');
Route::get('answer_register_page', [App\Http\Controllers\UserController::class, 'answer_register_page'])->name('answer-register-page');


//New Route create
//Campaign Idea
Route::get('campaign-index', [App\Http\Controllers\UserController::class, 'campaign_index'])->name('campaign-index');
Route::get('campaign-tab', [App\Http\Controllers\UserController::class, 'campaign_tab'])->name('campaign-tab');
Route::post('add-campaign-ideas', [App\Http\Controllers\UserController::class, 'add_campaign_ideas'])->name('add-campaign-ideas');
Route::get('campaign_idea_edit/{id}', [App\Http\Controllers\UserController::class, 'campaign_idea_edit'])->name('campaign-idea-edit');
Route::post('campaign_idea_update/{id}', [App\Http\Controllers\UserController::class, 'campaign_idea_update'])->name('campaign-idea-update');
Route::get('campaign_idea_delete/{id}', [App\Http\Controllers\UserController::class, 'campaign_idea_delete'])->name('campaign-idea-delete');

//Campaign Question
Route::get('question_form', [App\Http\Controllers\UserController::class, 'question_form'])->name('question-form');
Route::post('add_question_form', [App\Http\Controllers\UserController::class, 'add_question_form'])->name('add-question-form');
Route::get('campaign_question_table', [App\Http\Controllers\UserController::class, 'campaign_question_table'])->name('campaign-question-table');
Route::get('campaign_question_edit/{id}', [App\Http\Controllers\UserController::class, 'campaign_question_edit'])->name('campaign-question-edit');
Route::post('campaign_question_update/{id}', [App\Http\Controllers\UserController::class, 'campaign_question_update'])->name('campaign-question-update');
Route::get('campaign_question_delete/{id}', [App\Http\Controllers\UserController::class, 'campaign_question_delete'])->name('campaign-question-delete');


Route::group(['middleware' => ['auth']], function () {
    //Resource Route
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('permission', \App\Http\Controllers\PermissionController::class);

    Route::resource('resumes', \App\Http\Controllers\ResumeController::class);
    Route::resource('professional_skills', \App\Http\Controllers\ProfessionalSkillsController::class);
    Route::resource('work_experiences', \App\Http\Controllers\WorkExperienceController::class);
    Route::resource('educations', \App\Http\Controllers\EducationController::class);
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::resource('course', \App\Http\Controllers\CourseController::class);
    Route::resource('payment', \App\Http\Controllers\PaymentController::class);

    //Profile Update Code
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profile_update', [App\Http\Controllers\UserController::class, 'profile_update'])->name('profile-update');
    Route::post('/change_password', [App\Http\Controllers\UserController::class, 'change_password'])->name('change-password');


    //Backup Download
    Route::get('/backup_run', [App\Http\Controllers\UserController::class, 'backup_run'])->name('backup-run');
    Route::get('/backup_download', [App\Http\Controllers\UserController::class, 'backup_download'])->name('backup-download');

    //    Status Route Define
    Route::get('/userStatus', [App\Http\Controllers\UserController::class, 'userStatus'])->name('userStatus');
    Route::get('/professional_skillsStatus', [App\Http\Controllers\ProfessionalSkillsController::class, 'professional_skillsStatus'])->name('professional_skillsStatus');
    Route::get('/work_experiencesStatus', [App\Http\Controllers\WorkExperienceController::class, 'work_experiencesStatus'])->name('work_experiencesStatus');
    Route::get('/educationsStatus', [App\Http\Controllers\EducationController::class, 'educationsStatus'])->name('educationsStatus');
    Route::get('/projectsStatus', [App\Http\Controllers\ProjectController::class, 'projectsStatus'])->name('projectsStatus');
    Route::get('/courseStatus', [App\Http\Controllers\CourseController::class, 'courseStatus'])->name('courseStatus');
    Route::get('/preview_resume', [App\Http\Controllers\ResumeController::class, 'preview_resume'])->name('preview_resume');

    Route::get('/download-pdf', [App\Http\Controllers\ResumeController::class, 'downloadPDF'])->name('download-pdf');
    Route::get('/resume-details', [App\Http\Controllers\ResumeController::class, 'resume_details'])->name('resume-details');
    Route::get('/resume-demo', [App\Http\Controllers\ResumeController::class, 'resume_demo'])->name('resume-demo');
    Route::get('/resume-test', [App\Http\Controllers\ResumeController::class, 'resume_test'])->name('resume-test');
    Route::post('/updateProfilePicture', [App\Http\Controllers\UserController::class, 'updateProfilePicture'])->name('updateProfilePicture');


});
Route::get('/reload-captcha', [App\Http\Controllers\UserController::class, 'reloadCaptcha'])->name('reload-captcha');

Route::get('send-mail', [App\Http\Controllers\UserController::class, 'send_mail'])->name('send-mail');
Route::post('update-row-order', [App\Http\Controllers\ProductController::class, 'updateColumnOrder'])->name('update-row-order');

//Payment
Route::get('razorpay-payment', [App\Http\Controllers\RazorpayPaymentController::class, 'index'])->name('razorpay-payment');
Route::post('razorpay-payment-store', [App\Http\Controllers\RazorpayPaymentController::class, 'store'])->name('razorpay.payment.store');
Route::get('/online_pay', [App\Http\Controllers\PaymentController::class, 'online_pay'])->name('online-pay');
Route::get('/payment_history', [App\Http\Controllers\PaymentController::class, 'payment_history'])->name('payment-history');
Route::get('/payment_history_delete', [App\Http\Controllers\PaymentController::class, 'payment_history_delete'])->name('payment-history-delete');