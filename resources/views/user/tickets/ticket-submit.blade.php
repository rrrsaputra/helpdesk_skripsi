@extends('layouts.user')

@section('content')
<div class="dx-main">

    <div class="dx-separator"></div>
    <div class="dx-box-5 pb-100 bg-grey-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="dx-box dx-box-decorated">
                        <div class="dx-box-content">
                            <h2 class="h6 mb-6">Submit a Ticket</h2>
                            <!-- START: Breadcrumbs -->
                            <ul class="dx-breadcrumbs text-left dx-breadcrumbs-dark mnb-6 fs-14">
                                <li><a href="help-center.html">Support Home</a></li>
                                <li><a href="ticket.html">Ticket System</a></li>
                                <li>Submit Ticket</li>
                            </ul>
                            <!-- END: Breadcrumbs -->
                        </div>
                        <div class="dx-separator"></div>
                        <form action="#" class="dx-form">
                            <div class="dx-box-content">
                                <div class="dx-form-group">
                                    <label for="select-product" class="mnt-7">Select Product</label>
                                    <select class="form-control dx-select-ticket" name="" id="select-product">
                                        <option value="1"
                                            data-content='<img src="assets/images/product-1-xs.png" alt=""> Quantial'>
                                        </option>
                                        <option value="2"
                                            data-content='<img src="assets/images/product-2-xs.png" alt=""> Sensific'>
                                        </option>
                                        <option value="3"
                                            data-content='<img src="assets/images/product-3-xs.png" alt=""> Minist'>
                                        </option>
                                        <option value="4"
                                            data-content='<img src="assets/images/product-4-xs.png" alt=""> Desty'>
                                        </option>
                                        <option value="5"
                                            data-content='<img src="assets/images/product-5-xs.png" alt=""> Silies'>
                                        </option>
                                    </select>
                                </div>
                                <div class="dx-form-group">
                                    <div class="alert dx-alert dx-alert-primary" role="alert">* Your License. Purchase
                                        Date: 5 Nov 2018</div>
                                </div>
                            </div>
                            <div class="dx-separator"></div>
                            <div class="dx-box-content">
                                <div class="dx-form-group">
                                    <label for="subject" class="mnt-7">Subject</label>
                                    <input type="text" class="form-control form-control-style-2" id="subject"
                                        placeholder="Enter Subject">
                                </div>
                                <div class="dx-form-group">
                                    <label class="mnt-7">Description</label>
                                    <div class="dx-editor-quill">
                                        <div class="dx-editor" data-editor-height="150" data-editor-maxHeight="250">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="dx-box-content pt-0">
                            <!-- STRART: Dropzone

                    Additional Attributes:
                    data-dropzone-action
                    data-dropzone-maxMB
                    data-dropzone-maxFiles
                -->
                            <form class="dx-dropzone" action="#" data-dropzone-maxMB="5" data-dropzone-maxFiles="5">
                                <div class="dz-message">
                                    <div class="dx-dropzone-icon">
                                        <span class="icon pe-7s-cloud-upload"></span>
                                    </div>
                                    <div class="h6 dx-dropzone-title">Drop files here or click to upload</div>
                                    <div class="dx-dropzone-text">
                                        <p class="mnb-5 mnt-1">You can upload up to 5 files (maximum 5 MB each) of the
                                            following types: .jpg, .jpeg, .png, .zip.</p>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-between vertical-gap dx-dropzone-attachment">
                                <div class="col-auto dx-dropzone-attachment-add">
                                    <label class="mb-0" class="mnt-7"><span
                                            class="icon fas fa-paperclip mr-10"></span><span>Add
                                            Attachment</span></label>
                                </div>
                                <div class="col-auto dx-dropzone-attachment-btn">
                                    <button class="dx-btn dx-btn-lg" type="button" name="button">Submit a
                                        ticket</button>
                                </div>
                            </div>
                            <!-- END: Dropzone -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection