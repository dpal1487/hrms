  <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
      <!--begin::Thumbnail settings-->
      <div class="card card-flush py-4">
          <!--begin::Card header-->
          <div class="card-header">
              <!--begin::Card title-->
              <div class="card-title">
                  <h2>Thumbnail</h2>
              </div>
              {{ @$category->image->name }}

              <!--end::Card title-->
          </div>
          <!--end::Card header-->
          <!--begin::Card body-->
          <div class="card-body text-center pt-0">
              <!--begin::Image input-->
              <!--begin::Image input placeholder-->
              @if (@$category->image->name)
                  <style>
                      .image-input-placeholder {
                          background-image: url({{ asset('assets/image/category/original/') }}/{{ @$category->image->name }});
                      }
                  </style>
              @else
                  <style>
                      .image-input-placeholder {
                          background-image: url({{ asset('assets/media/svg/files/blank-image.svg') }});
                      }

                      [data-theme="dark"] .image-input-placeholder {
                          background-image: url({{ asset('assets/media/svg/files/blank-image-dark.svg') }});
                      }
                  </style>
              @endif
              <!--end::Image input placeholder-->
              <!--begin::Image input-->
              <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                  data-kt-image-input="true">
                  <!--begin::Preview existing avatar-->
                  <div class="image-input-wrapper w-150px h-150px"></div>
                  <!--end::Preview existing avatar-->
                  <!--begin::Label-->
                  <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                      <!--begin::Icon-->
                      <i class="bi bi-pencil-fill fs-7"></i>
                      <!--end::Icon-->
                      <!--begin::Inputs-->
                      <input type="file" name="category_image" id="imageInput" accept=".png, .jpg, .jpeg" />
                      <!--end::Inputs-->
                  </label>
                  <!--end::Label-->
                  <!--begin::Cancel-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                      <i class="bi bi-x fs-2"></i>
                  </span>
                  <input type="hidden" name="image" value="{{ @$category->image->id }}" id="image_id">

                  <!--end::Cancel-->
                  <!--begin::Remove-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                      <i class="bi bi-x fs-2"></i>
                  </span>
                  <!--end::Remove-->
              </div>
              <!--end::Image input-->
              <!--begin::Description-->

              <div class="fv-plugins-message-container invalid-feedback">
                  <div data-field="category_name" data-validator="notEmpty"> @error('category_name')
                          {{ $message }}
                      @enderror
                  </div>
              </div>
              <div class="text-muted fs-7">Set the category thumbnail image. Only *.png, *.jpg and *.jpeg image files
                  are accepted</div>
              <!--end::Description-->
          </div>
          <!--end::Card body-->
      </div>
      <!--end::Thumbnail settings-->

      <!--begin::Banner settings-->
      <div class="card card-flush py-4">
          <!--begin::Card header-->
          <div class="card-header">
              <!--begin::Card title-->
              <div class="card-title">
                  <h2>Banner Image </h2>
              </div>
              <!--end::Card title-->
              {{ @$category->banner->banner->name }}
          </div>
          <!--end::Card header-->
          <!--begin::Card body-->
          <div class="card-body text-center pt-0">
              <!--begin::Image input-->
              <!--begin::Image input placeholder-->
              @if (@$category->banner->banner->name)
                  <style>
                      .image-input-banner-placeholder {
                          background-image: url({{ asset('assets/image/category/categoryBanner/original/') }}/{{ @$category->banner->banner->name }});
                      }
                  </style>
              @else
                  <style>
                      .image-input-banner-placeholder {
                          background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                      }

                      [data-theme="dark"] .image-input-banner-placeholder {
                          background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                      }
                  </style>
              @endif
              <!--end::Image input placeholder-->
              <!--begin::Image input-->
              <div class="image-input image-input-empty image-input-outline image-input-banner-placeholder mb-3"
                  data-kt-image-input="true">
                  <!--begin::Preview existing avatar-->
                  <div class="image-input-wrapper w-150px h-150px"></div>
                  <!--end::Preview existing avatar-->
                  <!--begin::Label-->
                  <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                      <!--begin::Icon-->
                      <i class="bi bi-pencil-fill fs-7"></i>
                      <!--end::Icon-->
                      <!--begin::Inputs-->
                      <input type="file" name="banner_image" id="bannerimageInput" accept=".png, .jpg, .jpeg" />
                      <!--end::Inputs-->
                  </label>
                  <!--end::Label-->
                  <!--begin::Cancel-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                      <i class="bi bi-x fs-2"></i>
                  </span>
                  <input type="hidden" name="banner_id" value="{{ @$category->banner->banner->id }}"
                      id="banner_image_id">

                  <!--end::Cancel-->
                  <!--begin::Remove-->
                  <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                      <i class="bi bi-x fs-2"></i>
                  </span>
                  <!--end::Remove-->
              </div>
              <!--end::Banner Image input-->
              <!--begin::Description-->

              <div class="fv-plugins-message-container invalid-feedback">
                  <div data-field="category_name" data-validator="notEmpty"> @error('banner_image')
                          {{ $message }}
                      @enderror
                  </div>
              </div>
              <div class="text-muted fs-7">Set the Banner thumbnail image. Only *.png, *.jpg and *.jpeg image files
                  are accepted</div>
              <!--end::Description-->
          </div>
          <!--end::Card body-->
      </div>
      <!--end::Thumbnail settings-->

  </div>
  <!--end::Aside column-->
  <!--begin::Main column-->
  <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
      <!--begin::General options-->
      <div class="card card-flush py-4">
          <!--begin::Card header-->
          <div class="card-header">
              <div class="card-title">
                  <h2>Category</h2>
              </div>
          </div>
          <!--end::Card header-->
          <!--begin::Card body-->
          <div class="card-body pt-0">
              <!--begin::Input group-->
              <div class="row g-3">
                  <div class="mb-10 fv-row col-6">
                      <!--begin::Label-->
                      <label class="required form-label">Name</label>
                      <!--end::Label-->
                      <div class="">
                          <!--begin::Input-->
                          <input type="text" name="name" class="form-control mb-2" placeholder="Category name"
                              value="{{ @$category->name }}" />
                          <!--end::Input-->
                          <!--begin::Description-->
                          <div class="text-muted fs-7">A category name is required and recommended to be unique.</div>
                          <!--end::Description-->

                      </div>
                  </div>
                  <!--end::Input group-->
                  <div class="mb-1 fv-row col-6">

                      <label for="parent_category" class="required form-label">Parent Value</label>
                      <select class="form-select mb-2" name="parent" data-control="select2" data-hide-search="true"
                          data-placeholder="Select an option" id="parent_category">
                          <option value=" " selected>Parent</option>
                          @foreach ($categoryParent as $val)
                              <option value="{{ $val->id }}"> {{ $val->name }}</option>
                          @endforeach
                      </select>
                      <div class="text-muted fs-7">Category Parent Value Is Required.</div>
                  </div>
              </div>
              <div class="fv-row">
                  <!--begin::Label-->
                  <label class="form-label">Description</label>
                  <!--end::Label-->
                  <!--begin::Editor-->
                  <textarea name="category_description" class="form-control" placeholder="Categry Description">{{ strip_tags(@$category->description) }}</textarea>

                  <!--end::Editor-->
                  <!--begin::Description-->
                  <div class="text-muted fs-7">Set a description to the category for better visibility.</div>
                  <!--end::Description-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="fv-row">
                  <!--begin::Label-->
                  <label class="form-label">Keywords</label>
                  <!--end::Label-->
                  <!--begin::Editor-->
                  <input id="keywords" name="keywords" class="form-control mb-2"
                      value="{{ @$category->keywords }}" placeholder="Categry Keywords"/>
                  <!--end::Editor-->
                  <!--begin::Description-->
                  <div class="text-muted fs-7">Set a list of keywords that the category is related to. Separate the
                      keywords by adding a comma
                      <code>,</code>between each keyword.
                  </div>
                  <!--end::Description-->
              </div>
              <!--end::Input group-->
          </div>
          <!--end::Card header-->
      </div>
      <!--end::General options-->
      <!--begin::Meta options-->
      <div class="card card-flush py-4">
          <!--begin::Card header-->
          <div class="card-header">
              <div class="card-title">
                  <h2>Meta Options</h2>
              </div>
          </div>
          <!--end::Card header-->
          <!--begin::Card body-->
          <div class="card-body pt-0">
              <!--begin::Input group-->
              <div class="mb-10">
                  <!--begin::Label-->
                  <label class="form-label">Title</label>
                  <!--end::Label-->
                  <!--begin::Input-->
                  <input type="text" class="form-control mb-2" name="meta_tag" placeholder="Meta Tag Title"
                      value="{{ @$category->meta->tag }}" />
                  <!--end::Input-->
                  <!--begin::Description-->
                  <div class="text-muted fs-7">Set a meta tag title. Recommended to be simple and precise keywords.
                  </div>
                  <!--end::Description-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="mb-10 fv-row">
                  <!--begin::Label-->
                  <label class="form-label">Description</label>
                  <!--end::Label-->
                  <!--begin::Editor-->
                  <textarea name="meta_description" class="form-control" placeholder="Meta Tag Description">{{ strip_tags(@$category->meta->description) }}</textarea>
                  <!--begin::Description-->
                  <div class="text-muted fs-7">Set a meta tag description to the category for increased SEO ranking.
                  </div>
                  <!--end::Description-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div>
                  <!--begin::Label-->
                  <label class="form-label">Keywords</label>
                  <!--end::Label-->
                  <!--begin::Editor-->
                  <input id="meta_keywords" name="meta_keywords" class="form-control mb-2"
                      value="{{ @$category->meta->keywords }}" placeholder="Meta tag Keywords "/>
                  <!--end::Editor-->
                  <!--begin::Description-->
                  <div class="text-muted fs-7">Set a list of keywords that the category is related to. Separate the
                      keywords by adding a comma
                      <code>,</code>between each keyword.
                  </div>
                  <!--end::Description-->
              </div>
              <!--end::Input group-->
          </div>
          <!--end::Card header-->
      </div>
      <!--end::Meta options-->

      <div class="d-flex justify-content-end">
          <!--begin::Button-->
          <a href="{{ route('category.index') }}" class="btn btn-light me-5">Cancel</a>
          <!--end::Button-->
          <button type="submit" class="btn btn-primary" id="submit">
              <!--begin::Indicator label-->
              <span class="indicator-label">Save</span>
              <!--end::Indicator label-->
              <!--begin::Indicator progress-->
              <span class="indicator-progress">Please wait...
                  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              <!--end::Indicator progress-->
          </button>
          <!--end::Button-->
      </div>
  </div>
