@extends('layouts.contentNavbarLayout')

@section('title', 'Roles')

@section('users-management', 'active open')
@section('roles', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <h2>{{ transWord('Permissions') }}</h2>
            <form action="{{ route('users-roles-update-assign-permissions') }}" method="post">
                @csrf

                <input type="hidden" name="roleId" value="{{ $role->id }}">
                <input type="button" onclick='selects()' class="btn btn-success" value="{{ transWord('Select All') }}"/>  
                <input type="button" onclick='deSelect()' class="btn btn-danger" value="{{ transWord('Deselect All') }}"/>  
                <div class="row">
                    @foreach ($permissionsName as $moduleName)
                        <div class="card col-5 m-2">
                            <div class="d-flex align-items-end row">
                                <div class="card-body">
                                    <h4>{{ ucwords($moduleName) }}</h4>
                                    <hr>

                                    @foreach ($permissions as $permission)
                                        @if (explode('_', $permission->name)[1] == $moduleName)
                                            <div class="row">
                                                @if (in_array($permission->id, $assignedPermissions))
                                                <div class="col-12 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" checked>
                                                        <label class="form-check-label" for="permissions"> {{ transWord(ucwords(str_replace('_', ' ', $permission->name))) }}</label>
                                                    </div>
                                                </div>
                                                @else
                                                    <div class="col-12 mb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                                            <label class="form-check-label" for="permissions"> {{ transWord(ucwords(str_replace('_', ' ', $permission->name)))}}</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <button type="submit" class="btn btn-round btn-success col-md-1 me-2">{{ transWord('Save') }}</button>
                <a href="{{ route('users-roles-all') }}" style="width: 200px" class="btn btn-secondary"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ transWord('Back') }}</a>
            </form>       
        </div>    
    </div>
@endsection

@section('page-script')
    <script type="text/javascript">  
        function selects(){  
            var inputs = document.getElementsByTagName("input");
            var checkboxes=[];
            for(var i = 0; i < inputs.length; i++) {
                if(inputs[i].type == "checkbox") {
                    checkboxes.push( inputs[i] );
                    inputs[i].checked = true;
                }  
            }
        }  
        function deSelect(){  
            var inputs = document.getElementsByTagName("input");
            var checkboxes=[];
            for(var i = 0; i < inputs.length; i++) {
                if(inputs[i].type == "checkbox") {
                    checkboxes.push( inputs[i] );
                    inputs[i].checked = false;
                }  
            } 
        }             
    </script>  
@endsection