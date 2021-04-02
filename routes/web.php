<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyDataController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubscriptionController;
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


Route::get('/', function () {
    return view('test');
});

*/

    Route::get('/', [App\Http\Controllers\PagesController::class, 'index'])->name('pages.index');
    Route::get('why_agile', [App\Http\Controllers\PagesController::class, 'whyAgile'])->name('pages.why_agile');
    Route::get('about', [App\Http\Controllers\PagesController::class, 'about'])->name('pages.about');
    Route::get('instructors', [App\Http\Controllers\PagesController::class, 'instructors'])->name('pages.instructors');
  //  Route::get('/', [App\Http\Controllers\PagesController::class, 'test'])->name('pages.testfile');
    Route::get('partners', [App\Http\Controllers\PagesController::class, 'partners'])->name('pages.partners');
    //Route::get('contact', [App\Http\Controllers\PagesController::class, 'contact'])->name('pages.contact');
    Route::get('sign_up', [App\Http\Controllers\PagesController::class, 'signUp'])->name('pages.signUp');
    Route::get('dashboard_interim', [\App\Http\Controllers\PagesController::class, 'dashboard'])->name('pages.dashboard');
    Route::get('privacy_policy', [\App\Http\Controllers\PagesController::class, 'privacyPolicy'])->name('pages.privacy_policy');
    Route::get('terms_of_service', [\App\Http\Controllers\PagesController::class, 'termsOfService'])->name('pages.terms_of_service');
    Route::get('faqs', [\App\Http\Controllers\PagesController::class, 'faqs'])->name('pages.faqs');
    Route::get('help', [\App\Http\Controllers\PagesController::class, 'help'])->name('pages.help');
    Route::get('morehelp', [\App\Http\Controllers\PagesController::class, 'morehelp'])->name('pages.morehelp');
    Route::get('settings', [\App\Http\Controllers\PagesController::class, 'settings'])->name('pages.settings');
    Route::get('blog', [\App\Http\Controllers\PagesController::class, 'blog'])->name('pages.blog');

    //individual/////////////////////////////////////////////////////
    Route::resource('individual', IndividualController::class)->middleware('subscribed');
    Route::get('individual_profile', [\App\Http\Controllers\IndividualController::class, 'profile'])->name('individual.profile');
    Route::get('individual_image/{id}', [\App\Http\Controllers\IndividualController::class, 'changeImage'])->name('individual.changeImage');
    Route::get('individual_password/{id}', [\App\Http\Controllers\IndividualController::class, 'changePassword'])->name('individual.changePassword');
    Route::post('individual_image_store', [\App\Http\Controllers\IndividualController::class, 'changeImageStore'])->name('individual.changeImage');
    Route::post('individual_password_store', [\App\Http\Controllers\IndividualController::class, 'changePasswordStore'])->name('individual.changePassword');


    //methodologies
    Route::resource('methodology', \App\Http\Controllers\MethodologyController::class);
    Route::get('scrum', [App\Http\Controllers\MethodologyController::class, 'scrum'])->name('methodology.scrum');
    Route::get('crystal', [App\Http\Controllers\MethodologyController::class, 'crystal'])->name('methodology.crystal');
    Route::get('kanban', [App\Http\Controllers\MethodologyController::class, 'kanban'])->name('methodology.kanban');
    Route::get('ld', [App\Http\Controllers\MethodologyController::class, 'ld'])->name('methodology.ld');
    Route::get('dsdm', [App\Http\Controllers\MethodologyController::class, 'dsdm'])->name('methodology.dsdm');
    Route::get('xp', [App\Http\Controllers\MethodologyController::class, 'xp'])->name('methodology.xp');
    Route::get('fdd', [App\Http\Controllers\MethodologyController::class, 'fdd'])->name('methodology.fdd');


     //Sector
     Route::resource('sectors', \App\Http\Controllers\sectorController::class);
     Route::get('business', [App\Http\Controllers\sectorController::class, 'business'])->name('sectors.business');
     Route::get('defense', [App\Http\Controllers\sectorController::class, 'defense'])->name('sectors.defense');
     Route::get('fc', [App\Http\Controllers\sectorController::class, 'fc'])->name('sectors.fc');
     Route::get('government', [App\Http\Controllers\sectorController::class, 'government'])->name('sectors.government');
     Route::get('hospitality', [App\Http\Controllers\sectorController::class, 'hospitality'])->name('sectors.hospitality');
     Route::get('info_tech', [App\Http\Controllers\sectorController::class, 'info_tech'])->name('sectors.info_tech');
     Route::get('media', [App\Http\Controllers\sectorController::class, 'media'])->name('sectors.media');
     Route::get('legal', [App\Http\Controllers\sectorController::class, 'legal'])->name('sectors.legal');
     Route::get('medical', [App\Http\Controllers\sectorController::class, 'medical'])->name('sectors.medical');



    //admin
    Route::resource('admin', AdminController::class)->middleware('mustBeAdmin');
    Route::get('admin_add_instructors',  [App\Http\Controllers\AdminController::class, 'add_instructors'])->name('admin.addInstructors');
    Route::get('admin_instructors',  [App\Http\Controllers\AdminController::class, 'instructors'])->name('admin.instructors');
    Route::get('admin_questions',  [App\Http\Controllers\AdminController::class, 'questions'])->name('admin.questions');
    Route::get('admin_faq',  [App\Http\Controllers\AdminController::class, 'faq'])->name('admin.faq');
    Route::get('admin_users',  [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('admin_subscriptions',  [App\Http\Controllers\AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    Route::get('admin_assign_login/{id}',  [App\Http\Controllers\AdminController::class, 'adminAssignLogin'])->name('admin.assignLogin');
    Route::post('login_store',  [App\Http\Controllers\AdminController::class, 'loginStore'])->name('admin.loginStore');

//contact
Route::resource('contact', ContactController::class);


    //corporate
//    Route::resource('corporate', CorporateController::class)->middleware('subscribed');
    Route::resource('corporate', CorporateController::class);
    Route::get('corporate_members',  [App\Http\Controllers\CorporateController::class, 'members'])->name('corporate.members');
    Route::get('corporate_add_member',  [App\Http\Controllers\CorporateController::class, 'add_member'])->name('corporate.addMember');
    Route::get('corporate_profile',  [App\Http\Controllers\CorporateController::class, 'profile'])->name('corporate.profile');

    ///corporate members
    Route::resource('company_data', CompanyDataController::class);

    //profile
    Route::resource('profile', \App\Http\Controllers\ProfileController::class);


    //subscription
    Route::resource('subscription', SubscriptionController::class);
    Route::post('choose_quantity', [SubscriptionController::class, 'corporate'])->name('subscription.corporate');
    Route::post('corporate_payment', [SubscriptionController::class, 'payment'])->name('subscription.payment');
    Route::post('corporate_form', [SubscriptionController::class, 'corporateform'])->name('subscription.corporateform');




   ////courses
    Route::get('courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
    Route::get('sfc', [App\Http\Controllers\CourseController::class, 'sfc'])->name('courses.sfc');
    Route::get('smc', [App\Http\Controllers\CourseController::class, 'smc'])->name('courses.smc');
    Route::get('afc', [App\Http\Controllers\CourseController::class, 'afc'])->name('courses.afc');
    Route::get('amc', [App\Http\Controllers\CourseController::class, 'amc'])->name('courses.amc');
    Route::get('poc', [App\Http\Controllers\CourseController::class, 'poc'])->name('courses.poc');
    Route::get('othercourses', [App\Http\Controllers\CourseController::class, 'othercourses'])->name('courses.othercourses');
    Route::get('course_register', [App\Http\Controllers\CourseController::class, 'courseRegister'])->name('courses.course_register');
    Route::post('course_register', [App\Http\Controllers\CourseController::class, 'courseRegisterStore'])->name('courses.course_register');


    //comment
     Route::resource('comment', \App\Http\Controllers\CommentController::class);

    //instructor
    Route::resource('instructor', InstructorController::class);
    Route::get('success-page', [InstructorController::class, 'successPage'])->name('instructor.successpage');
    Route::post('instructor/question/answer', [InstructorController::class, 'answer'])->name('instructor.answer');
    Route::get('instructor_profile', [InstructorController::class, 'profile'])->name('instructor.profile');
    Route::post('instructor_profilestore', [InstructorController::class, 'profileStore'])->name('instructor.profileStore');
    Route::get('instructor_review', [InstructorController::class, 'review'])->name('instructor.review');
    //questions
    Route::resource('questions', QuestionController::class);
    Route::post('upload', [QuestionController::class, 'upload'])->name('questions.upload');
    //    Auth::routes();
    Auth::routes(['verify' => true]);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('{path}', [\App\Http\Controllers\PagesController::class, 'index'])->where('path', '([A-z\d\-\/_.]+)?');
