<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h2 class="pageheader-title">@yield('pagetitle', config('app.name').' Dashboard')</h2>
      @yield('button')
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            @yield('breadcumb')
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>