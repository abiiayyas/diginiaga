@php
    $templateView = $view ?? 'shopee';
@endphp
@include('lp.' . $templateView, ['landingPage' => $landingPage, 'utmQuery' => $utmQuery])
