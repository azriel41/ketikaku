@extends('layouts_backend._main_backend')

@section('extra_styles')
@endsection

@section('content')
   <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <div class="card border-success">
                <div class="card-header bg-success">
                    <h4 class="m-b-0 text-white">Card Title</h4></div>
                <div class="card-body">
                     <div class="text-right mb-3">
                    <a href="{{ route('write_novel_create') }}" class="btn waves-effect waves-light btn-md btn-success"><i class="fas fa-plus
    "></i> Create Novel</a>
                </div>
                   <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered font-weight-bold" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="25%">Title</th>
                                    <th>Create Date</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th width="35%">Photo</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $element)
                                    <tr>
                                        <td align="center">{{ $index+1 }}</td>
                                        <td><a href="{{ route('write_chapter',['id'=>$element->dn_id]) }}"><span style="font-size: 13px !important;" class="label label-success font-weight-bold">{{ $element->dn_title }}</span></a></td>
                                        <td>{{ date('d M Y  -  h:i',strtotime($element->dn_created_at)) }}</td>
                                        <td align="center">
                                            @if ($element->dn_status == 'publish')
                                                <span class="label label-rounded label-success">Published</span>
                                            @else
                                                <span class="label label-rounded label-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">
                                            Subscriber : {{ $element->subscriber == null ? '0' : $element->subscriber }}
                                            <br>
                                            Liked : {{ $element->liked == null ? '0' : $element->liked }}
                                            <br>
                                            
                                        </td>
                                        <td align="center">
                                            @if ($element->dn_cover == null)
                                                <span class="label label-rounded label-danger">No Image</span>
                                            @else
                                                <img width="30%" src="{{ asset('/storage/app/'.$element->dn_cover) }}?{{ time() }}">
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn waves-effect waves-light btn-sm btn-warning" href="{{ route('write_novel_edit', ['id' => $element->dn_id]) }}"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger delete" value="{{ $element->dn_id }}" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
              
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        $('#zero_config').DataTable();

        $('.delete').on('click', function () {

       var this_val = $(this).val();

       iziToast.question({
                theme: 'dark',
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                backgroundColor: '#1f1f22',
                icon: 'fa fa-info-circle',
                title: 'Are you Sure!',
                message: '',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button style="background-color:red;"> Delete </button>', function (instance, toast) {

                        $.ajax({
                            url  : baseUrl+'/write'+'/write_novel/delete/'+this_val,
                            type :'get',
                            success:function(data){
                                if (data.status == 'sukses') {
                                    iziToast.success({position: 'topRight',message: 'Successfully Deleted!'});
                                    window.location=('{{ route('write_novel') }}')
                                }else{
                                    iziToast.error({position: 'topRight',message: 'Error Check your data! '});
                                }
                            },
                            error:function(data){

                            }

                        })

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true], // true to focus
                    ['<button> Cancel </button>', function (instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy){
                                console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                            }
                        }, toast, 'buttonName');
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ],
                onOpening: function(instance, toast){
                    console.info('callback abriu!');
                },
                onClosing: function(instance, toast, closedBy){
                    console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
                }
            });
        
    });

    </script>

@endsection



    

       