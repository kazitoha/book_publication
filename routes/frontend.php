<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('public/bbr.nexiobd.com', function () {
    return redirect('public');
});
Route::get('bbr.nexiobd.com', function () {
    return redirect('/');
});
//contact-us
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('contact-us', [HomeController::class, 'contactUs']);
//notice
Route::get('single-notice/{slug}', [HomeController::class, 'singleNotice']);
Route::get('all-notice', [HomeController::class, 'allNotice']);
//event
Route::get('single-event/{slug}', [HomeController::class, 'singleEvent']);
Route::get('all-event', [HomeController::class, 'allEvent']);
//news
Route::get('single-news/{slug}', [HomeController::class, 'singleNews']);
//gallery
Route::get('gallery', [HomeController::class, 'gallery']);
//all news
Route::get('all-news', [HomeController::class, 'allNews']);
//staff
Route::get('all-staff', [HomeController::class, 'allStaff']);
//Message form Chairman
Route::get('chairman-msg', [HomeController::class, 'chairmanMsg']);
//Message Form Director
Route::get('director-msg', [HomeController::class, 'directorMsg']);

//history of bbr
Route::get('bbr-history', [HomeController::class, 'historyOfBbbr']);
//guide-lines
Route::get('guide-lines', [HomeController::class, 'guideLines']);
//publication
Route::get('publication', [HomeController::class, 'publication']);
//Research team
Route::get('research-team', [HomeController::class, 'researchTeam']);
////Organogram
Route::get('chairman-&-director-list', [HomeController::class, 'chairmanDirectorList']);
//Training & Development
Route::get('training-&-development', [HomeController::class, 'trainingAndDevelopment']);
//researchMethodologyTraining
Route::get('research-methodology-training', [HomeController::class, 'researchMethodologyTraining']);
//Software Training
Route::get('software-training', [HomeController::class, 'softwareTraining']);
//Consultancy and Industrial Problem solving
Route::get('consultancy-and-industrial-problem-solving', [HomeController::class, 'consultancyAndIndustrialProblemSolving']);
//corporate-training
Route::get('corporate-training', [HomeController::class, 'corporateTraining']);
//ongoing-projects
Route::get('ongoing-projects', [HomeController::class, 'ongoingProjects']);
Route::get('list-of-the-Committee', [HomeController::class, 'listOfTheCommittee']);
