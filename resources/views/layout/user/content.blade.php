                  <!-- BEGIN CONTAINER -->
                  <div class="page-container">
                      <!-- BEGIN CONTENT -->
                      <div class="page-content-wrapper">
                          <!-- BEGIN CONTENT BODY -->
                          <?php //@include('layout.user.content.page_head') ?>
                          <!-- BEGIN PAGE CONTENT BODY -->
                          <div class="page-content">
                              <div class="container-fluid">
                                <?php //@include('layout.user.content.breadcrumb') ?>
                                  <!-- BEGIN PAGE CONTENT INNER -->
                                  <div class="page-content-inner">
                                      <div class="mt-content-body">
                                      @yield('content')
                                      </div>
                                  </div>
                                  <!-- END PAGE CONTENT INNER -->
                              </div>
                          </div>
                          <!-- END PAGE CONTENT BODY -->
                          <!-- END CONTENT BODY -->
                      </div>
                      <!-- END CONTENT -->
                      @include('layout.user.content.sidebar')
                  </div>
                  <!-- END CONTAINER -->
