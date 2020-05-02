<a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}" class="btn btn-danger btn-cancel"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
