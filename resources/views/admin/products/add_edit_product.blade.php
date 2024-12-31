@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Products Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
              </div>
              <!-- /.card-header -->
              @if(Session::has('error_message')) 
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 5px;">
                <strong>Error!</strong> {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 5px;">
                <strong>Success!</strong> {{ Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 5px;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              @endif
              <!-- form start -->
              <form name="productForm" id="productForm" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="parent_id">Select Category*</label>
                    <select name="category_id" class="form-control"> 
                      <option value="">Select</option>
                        <?php foreach ($getCategories as $key => $cat) {?>
                              <option @if(!empty(@old('category_id')) && $cat['_id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) && $product['category_id']==$cat['_id']) selected="" @endif value="{{$cat['_id']}}">&#9679;&nbsp;{{$cat['category_name']}}</option>
                              <?php if(!empty($cat['subcategories'])){
                                  foreach ($cat['subcategories'] as $key => $subcat) { ?>
                                      <option @if(!empty(@old('category_id')) && $subcat['_id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) && $product['category_id']==$subcat['_id']) selected="" @endif value="{{$subcat['_id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['category_name']}}</option>
                                      <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                      <option @if(!empty(@old('category_id')) && $subsubcat['_id']==@old('category_id')) selected="" @elseif(!empty($product['category_id']) && $product['category_id']==$subsubcat['_id']) selected="" @endif value="{{$subsubcat['_id']}}">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['category_name']}}</option>
                                  <?php } 
                                  }
                              }
                          } ?>
                    </select>
                  </div>
                  <div class="form-group">
                   <label for="category_id">Select Brand*</label>
                   <select id="brand_id" name="brand_id" class="form-control" style="width: 100%;">
                            <option value="">Select</option>
                              @foreach($brands as $brand)
                                <option value="{{ $brand['_id'] }}" @if(!empty($product['brand_id']) && $product['brand_id'] == $brand['_id']) selected @endif>{{ $brand['brand_name'] }}</option>
                              @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="product_name">Product Name*</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ @old('product_name') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_code">Product Code*</label>
                    <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Enter Product Code" @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ @old('product_code') }}" @endif>
                  </div>
                  <div class="form-group">
                      <label for="product_price">Product Price</label>
                      <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ @old('product_price') }}" @endif>
                  </div>
                  <div class="form-group">
                      <label for="product_discount">Product Discount (%)</label>
                      <input type="text" class="form-control" id="product_discount" name="product_discount" placeholder="Enter Product Discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ @old('product_discount') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_color">Product Color*</label>
                    <input type="text" class="form-control" id="product_color" name="product_color" placeholder="Enter Product Color" @if(!empty($product['product_color'])) value="{{ $product['product_color'] }}" @else value="{{ @old('product_color') }}" @endif>
                  </div>
                  <?php $familyColors = \App\Models\Color::colors();  ?>
                  <div class="form-group">
                    <label for="family_color">Family Color</label>
                    <select name="family_color" class="form-control">
                        <option value="">Please Select</option>
                        @foreach($familyColors as $color)
                            <option value="{{$color->color_name}}" @if(isset($product['family_color']) && $product['family_color'] ==$color->color_name) selected @endif>{{$color->color_name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="group_code">Group Code</label>
                    <input type="text" class="form-control" id="group_code" name="group_code" placeholder="Enter Group Code" @if(!empty($product['group_code'])) value="{{ $product['group_code'] }}" @else value="{{ @old('group_code') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                    <input type="text" class="form-control" id="product_weight" name="product_weight" placeholder="Enter Product Weight" @if(!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ @old('product_weight') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_images">Product Images (Recommend Size: 1040 x 1200)</label>
                    <input type="file" class="form-control" id="product_images" name="product_images[]" multiple>
                    <table cellpadding="10" cellspacing="10" style="padding: 5px;"><tr>
                    @foreach($product['images'] as $image)
                      <td>
                        <a target="_blank" href="{{ url('front/images/products/small/'.$image['image']) }}"><img style="width:60px;" src="{{ asset('front/images/products/small/'.$image['image']) }}"></a>&nbsp;
                        <input type="hidden" name="image[]" value="{{ $image['image'] }}">
                        <input style="width:40px;" type="text" placeholder="Sort" name="image_sort[]" value="{{ $image['image_sort'] }}">  
                        <a style='color:#3f6ed3;' class="confirmDelete" title="Delete Product Image" href="javascript:void(0)" record="product-image" recordid="{{ $image['id'] }}"><i class="fas fa-trash"></i></a>
                    @endforeach
                    </tr>
                    </table>
                  </div>
                  <div class="form-group">
                    <label for="product_video">Product Attributes</label>
                    <div class="field_wrapper">
                      <input title="Required" type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;">
                      <input title="Required" type="text" name="size[]" id="size" placeholder="Size" style="width:120px;">
                      <input title="Required" type="text" name="price[]" id="price" placeholder="Price" style="width:120px;"> 
                      <input title="Required" type="text" name="stock[]" id="stock" placeholder="Stock" style="width:120px;">
                      <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                    </div>
                  </div>
                  @if(count($product['attributes'])>0)
                <div class="form-group">
                  <label>Attributes</label>
                  <table style="background-color:#cccccc !important; width: 100%;" cellpadding="5">
                    <tr>
                      <th>Size</th>
                      <th>SKU</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Actions</th>
                    </tr>
                      @foreach($product['attributes'] as $attribute)
                        <input style="display: none;" type="text" name="attrId[]" value="{{ $attribute['_id'] }}">
                        <tr>
                          <td>{{ $attribute['size'] }}</td>
                          <td>{{ $attribute['sku'] }}</td>
                          <td>
                            <input style="width:100px;" type="number" name="update_price[]" value="{{ $attribute['price'] }}" required="">
                          </td>
                          <td>
                            <input style="width:100px;" type="number" name="update_stock[]" value="{{ $attribute['stock'] }}" required="">
                          </td>
                          <td>
                          @if($attribute['status']==1)
                            <a class="updateAttributeStatus" id="attribute-{{ $attribute['_id'] }}" attribute_id="{{ $attribute['_id'] }}" style='color:#3f6ed3' href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                          @else
                            <a class="updateAttributeStatus" id="attribute-{{ $attribute['_id'] }}" attribute_id="{{ $attribute['_id'] }}" style="color:grey" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                          @endif
                           &nbsp;&nbsp;
                          <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="attribute" recordid="{{ $attribute['_id'] }}"><i class="fas fa-trash"></i></a> 
                          </td>
                        </tr>
                      @endforeach
                    </table>
                  </div>
                  @endif

                  <div class="form-group">
                      <label for="product_video">Product Video (Recommend Size: Less then 2 MB)</label>
                      <input type="file" class="form-control" id="product_video" name="product_video">
                      @if(!empty($product['product_video']))
                        <a target="_blank" href="{{ url('front/videos/products/'.$product['product_video']) }}">View Video</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" record="product-video" recordid="{{ $product['id'] }}">Delete Video</a>
                      @endif
                    </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Product Description">@if(!empty($product['description'])) {{ $product['description'] }} @else {{ @old('description') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="wash_care">Wash Care</label>
                    <textarea class="form-control" rows="3" id="wash_care" name="wash_care" placeholder="Enter Product Wash Care">@if(!empty($product['wash_care'])) {{ $product['wash_care'] }} @else {{ @old('wash_care') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="fabric">Fabric</label>
                    <select name="fabric" class="form-control">
                      <option value="">Select</option>
                      @foreach($productFilters['fabricArray'] as $fabric)
                        <option value="{{$fabric}}" @if(!empty(@old('fabric')) && @old('fabric')==$fabric) selected="" @elseif(!empty($product['fabric']) && $product['fabric']==$fabric) selected="" @endif>{{$fabric}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="sleeve">Sleeve</label>
                    <select name="sleeve" class="form-control">
                      <option value="">Select</option>
                      @foreach($productFilters['sleeveArray'] as $sleeve)
                        <option value="{{$sleeve}}" @if(!empty(@old('sleeve')) && @old('sleeve')==$sleeve) selected="" @elseif(!empty($product['sleeve']) && $product['sleeve']==$sleeve) selected="" @endif>{{$sleeve}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="pattern">Pattern</label>
                    <select name="pattern" class="form-control">
                      <option value="">Select</option>
                      @foreach($productFilters['patternArray'] as $pattern)
                        <option value="{{$pattern}}" @if(!empty(@old('pattern')) && @old('pattern')==$pattern) selected="" @elseif(!empty($product['pattern']) && $product['pattern']==$pattern) selected="" @endif>{{$pattern}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="fit">Fit</label>
                    <select name="fit" class="form-control">
                      <option value="">Select</option>
                      @foreach($productFilters['fitArray'] as $fit)
                        <option value="{{$fit}}" @if(!empty(@old('fit')) && @old('fit')==$fit) selected="" @elseif(!empty($product['fit']) && $product['fit']==$fit) selected="" @endif>{{$fit}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="occasion">Occasion</label>
                    <select name="occasion" class="form-control">
                      <option value="">Select</option>
                      @foreach($productFilters['occasionArray'] as $occasion)
                        <option value="{{$occasion}}" @if(!empty(@old('occasion')) && @old('occasion')==$occasion) selected="" @elseif(!empty($product['occasion']) && $product['occasion']==$occasion) selected="" @endif>{{$occasion}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="search_keywords">Search Keywords</label>
                    <textarea class="form-control" rows="3" id="search_keywords" name="search_keywords" placeholder="Enter Product Search Keywords">@if(!empty($product['search_keywords'])) {{ $product['search_keywords'] }} @else {{ @old('search_keywords') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ @old('meta_title') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ @old('meta_description') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ @old('meta_keywords') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="is_featured">Featured Item</label>
                    <input type="checkbox" name="is_featured" value="Yes" @if(!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                  </div>
                  <div class="form-group">
                    <label for="is_bestseller">Best Seller</label>
                    <input type="checkbox" name="is_bestseller" value="Yes" @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes") checked="" @endif>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection