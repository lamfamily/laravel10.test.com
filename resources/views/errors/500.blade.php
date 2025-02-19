@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')
@section('message', $exception->getMessage() ?: 'Something went wrong on the server.')
