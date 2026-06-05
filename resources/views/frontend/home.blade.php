@extends('frontend.layouts.app')

@section('content')
    @include('frontend.components.topBanner')
    @include('frontend.components.stats')
    @include('frontend.components.location')
    @include('frontend.components.cta')
    @include('frontend.components.newsletter')
@endsection
