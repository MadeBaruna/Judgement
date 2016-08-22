<?php
    $startPage = $page->currentPage() <= 5 ? 1 : $page->currentPage() - 2;
    $endPage = $page->currentPage() >= $page->lastPage()-5 ? $page->lastPage() : $startPage + 4;
    $endPage = $startPage == 1 ? $startPage + 6 : $endPage;
    $startPage = $endPage == $page->lastPage() ? $page->lastPage()-6 : $startPage;

    $endPage = min($endPage, $page->lastPage());
?>
@if($page->currentPage() == 1)
    <div class="icon disabled item">
        <i class="left chevron icon"></i>
    </div>
@else
    <a href="{{ $page->previousPageUrl() }}" class="icon item">
        <i class="left chevron icon"></i>
    </a>
@endif
@if($startPage > 1)
    <a href="{{ $page->url(1) }}" class="item">
        1
    </a>
    <a href="{{ $page->url(2) }}" class="item">
        2
    </a>
    <div class="disabled item">
        ...
    </div>
@endif
@for ($i = $startPage; $i <= $endPage; $i++)
    <a href="{{ $page->url($i) }}" class="item {{ ($page->currentPage() == $i) ? ' active' : '' }}">
        {{ $i }}
    </a>
@endfor
@if($endPage < $page->lastPage()-2)
    <div class="disabled item">
        ...
    </div>
    <a href="{{ $page->url($page->lastPage()-1) }}" class="item">
        {{ $page->lastPage()-1 }}
    </a>
    <a href="{{ $page->url($page->lastPage()) }}" class="item">
        {{ $page->lastPage() }}
    </a>
@endif
@if($page->currentPage() == $page->lastPage())
    <div class="icon disabled item">
        <i class="right chevron icon"></i>
    </div>
@else
    <a href="{{ $page->nextPageUrl() }}" class="icon item">
        <i class="right chevron icon"></i>
    </a>
@endif