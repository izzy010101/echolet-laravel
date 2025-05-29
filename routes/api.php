<?php

Route::middleware('auth:sanctum')->get('/user/theme-color', function (Request $request) {
    return response()->json(['theme_color' => $request->user()->theme_color]);
});

Route::middleware('auth:sanctum')->put('/user/theme-color', function (Request $request) {
    $request->validate(['theme_color' => 'required|string']);
    $user = $request->user();
    $user->theme_color = $request->theme_color;
    $user->save();
    return response()->json(['message' => 'Theme color updated']);
});
