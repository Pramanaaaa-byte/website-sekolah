<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\KeterlambatanController;

// Temporary routes without middleware for testing
Route::get("/temp-izin-keluar-create", [IzinKeluarController::class, "create"]);
Route::get("/temp-keterlambatan-create", [KeterlambatanController::class, "create"]);

Route::post("/temp-izin-keluar-store", [IzinKeluarController::class, "store"]);
Route::post("/temp-keterlambatan-store", [KeterlambatanController::class, "store"]);
