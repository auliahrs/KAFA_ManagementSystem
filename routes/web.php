<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentResultController;
use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->middleware('auth')->group(function () {
    Route::get('/kafa/kafaHomepage', 'kafaHomepage')->name('kafa.kafaHomepage');
    Route::get('/muip/muipHomepage', 'muipHomepage')->name('muip.muipHomepage');
    Route::get('/guardian/guardianHomepage', 'guardianHomepage')->name('guardian.guardianHomepage');
    Route::get('/teacher/teacherHomepage', 'teacherHomepage')->name('teacher.teacherHomepage');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(ActivityController::class)->middleware('auth')->group(function () {
     // Routes for KAFA management
    Route::get('/kafa/manageActivity', 'kafaManageActivity')->name('kafa.manageActivity');
    Route::get('/kafa/addActivity', 'kafaAddActivity')->name('kafa.addActivity');
    Route::post('/kafa/storeActivity', 'kafaStoreActivity')->name('kafa.storeActivity'); // Use POST method for storing activity
    Route::get('/kafa/editActivity/{id}', 'kafaEditActivity')->name('kafa.editActivity');
    Route::put('/kafa/updateActivity/{activity}', 'kafaUpdateActivity')->name('kafa.updateActivity'); // Change to PUT method
    Route::delete('/kafa/deleteActivity/{id}', 'kafaDeleteActivity')->name('kafa.deleteActivity'); // Change to DELETE method
    Route::get('/kafa/viewActivity/{activity}', 'kafaViewActivity')->name('kafa.viewActivity');
    
    // Routes for MUIP management
    Route::get('/muip/manageActivity', 'muipManageActivity')->name('muip.manageActivity');
    Route::get('/muip/viewActivity/{activity}', 'muipViewActivity')->name('muip.viewActivity');
    Route::get('/muip/approveActivity', 'muipApproveActivity')->name('muip.approveActivity');
    Route::post('/muip/approveActivity/{id}', 'approveActivity')->name('muip.approveActivityAction');
    Route::delete('/muip/rejectActivity/{id}', 'rejectActivity')->name('muip.rejectActivityAction');

    // Routes for Guardian management
    Route::get('/guardian/manageActivity', 'guardianManageActivity')->name('guardian.manageActivity');
    Route::get('/guardian/viewActivity/{activity}', 'guardianViewActivity')->name('guardian.viewActivity');
    
    // Routes for Teacher management
    Route::get('/teacher/manageActivity', 'teacherManageActivity')->name('teacher.manageActivity');
    Route::get('/teacher/viewActivity/{activity}', 'teacherViewActivity')->name('teacher.viewActivity');
});


Route::controller(ReportController::class)->middleware('auth')->group(function () {
    Route::get('/kafa/listReportActivity', 'kafaListReportActivity')->name('kafa.listReportActivity');
    Route::get('/kafa/{activity}/viewReportActivity', 'kafaViewReportActivity')->name('kafa.viewReportActivity');
    Route::get('/kafa/{activity}/createReportActivity', 'kafaCreateReportActivity')->name('kafa.createReportActivity');
    Route::put('/kafa/{activity}/updateReportActivity', 'kafaUpdateReportActivity')->name('kafa.updateReportActivity');
    Route::get('/muip/listReportActivity', 'muipListReportActivity')->name('muip.listReportActivity');
    Route::get('/muip/{activity}/viewReportActivity', 'muipViewReportActivity')->name('muip.viewReportActivity');
    Route::get('/muip/listClassReport', 'muipListClassReport')->name('muip.listClassReport');
    Route::get('/muip/{classroom}/classAcademicReport', 'muipClassAcademicReport')->name('muip.classAcademicReport');
    Route::get('/muip/{student}/{classroom}/studentAcademicReport', 'muipStudentAcademicReport')->name('muip.studentAcademicReport');
});

Route::controller(StudentResultController::class)->middleware('auth')->group(function () {
    Route::get('/teacher/listStudent', 'teacherListStudent')->name('teacher.listStudent');
    Route::get('/teacher/addResult/{studentID}', 'teacherAddResult')->name('teacher.addResult');
    Route::get('/teacher/viewResult/{studentID}', 'teacherViewResult')->name('teacher.viewResult');
    Route::get('/teacher/editResult/{studentID}', 'teacherEditResult')->name('teacher.editResult');
    Route::get('/teacher/filterResult', 'teacherFilterResult')->name('teacher.filterResult');
    Route::post('/teacher/manage-result', 'store')->name('teacher.storeResult');
});

Route::controller(TimetableController::class)->middleware('auth')->group(function () {
    //routes to display the timetable index page
Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');

//route to display the timetable form
Route::get('/timetable/create-timetable', [TimetableController::class, 'showCreateTimetable'])->name('timetable.create');

//route to submit the timetable form data
Route::post('/timetable/create-timetable', [TimetableController::class, 'saveTimetable'])->name('timetable.save');

//route to display the view timetable
Route::get('timetable/{id}/view-timetable', [TimetableController::class, 'viewTimetable'])->name('timetable.view');

//route to edit the timetable
Route::get('/timetable/{id}/update-timetable', [TimetableController::class, 'editTimetable'])->name('timetable.edit');

//route to update the timetable
Route::put('/timetable/{id}/update-timetable', [TimetableController::class, 'updateTimetable'])->name('timetable.update');

//route to delete the timetable
Route::delete('/timetable/{id}/delete-timetable', [TimetableController::class, 'deleteTimetable'])->name('timetable.delete');

});

require __DIR__.'/auth.php';