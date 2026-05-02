@echo off
setlocal enabledelayedexpansion

REM Get to the right directory
pushd %~dp0

REM Run php from the php installation directory, if one is provided
set PHP_ARGS=-d output_buffering=Off %*

REM Find php using where command
for /f "delims=" %%i in ('where php') do (
    set PHP_BINARY=%%i
)

if "%PHP_BINARY%" equ "" (
    echo Could not find php executable
    exit /B 1
)

REM Execute the artisan file
"%PHP_BINARY%" "%~dp0artisan" %PHP_ARGS%
