<!-- Product Detail Modal -->
<div class="program-modal modal fade" id="ProductDetailModal" tabindex="-1" role="dialog" aria-hidden="true"
  data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-bs-dismiss="modal"><img src="{{ asset('storage/icons/close-icon.svg') }}"
                  alt="Close Modal" />
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="modal-body">
                            <!-- Product details-->
                            <h2 class="text-uppercase text-center mb-2 product-title"></h2>
                            <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                                <span class="badge bg-warning text-dark egg-size"></span>
                                <span class="badge bg-light text-muted egg-pack"></span>
                            </div>
                            <img id="modal-image" width="70%" class="img-fluid d-block mx-auto rounded-4 shadow" alt="" />
                            <div class="mt-4">
                                <h3 class="h5 text-uppercase text-center mb-3">Product Details</h3>
                                <div class="content text-start">
                                    <p class="description mb-3"></p>
                                    <ul class="list-unstyled mb-0">
                                        <li class="price fw-semibold mb-2"></li>
                                        <li class="discount mb-2"></li>
                                        <li class="stock"></li>
                                    </ul>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-xl j mt-4" data-bs-dismiss="modal" type="button"> Back to
                                Product List</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Detail Modal -->