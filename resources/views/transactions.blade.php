@extends('layouts.app')

@section('title', 'Transacciones')

@section('content')
	
    <div class="container py-5">
        <h1 class="text-center mb-5">
            <a href="{{ route('users', [$token]) }}" class="text-decoration-none"><<a> Lista de transacciones del cliente ID: {{ $client_id }}
        </h1>

        <div class="401 alert alert-danger d-none" role="alert">
            
        </div>

        <div class="204 alert alert-warning d-none" role="alert">
            No existen transacciones por mostrar.
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col" class="w-50">Message</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody class="lista">
                
            </tbody>            
        </table>

        <div class="paginator">

        </div>
    </div>

	<script type="text/javascript">
        var url = "{{ route('api-transactions', [$token, $client_id]) }}?page={{$page}}";
        function addEventAjax(url){
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    $.each(data["data"], function(i, val) {
                        var type = val["type"];
                        if(type == "withdraw")
                            var classtype = "table-danger";
                        else
                            var classtype = "table-success";

                        $(".lista").append('<tr class="'+classtype+'"><th scope="row">'+(i+1)+'</th><td>$'+val["amount"]+'</td><td>'+val["type"]+'</td><td>'+val["message"]+'</td><td>'+val["created_at"]+'</td></tr>');

                        
                    });       
                        
                    $.each(data["meta"]["links"], function(i, val) {
                        var disabled = val["active"];
                        if(disabled == true)
                            classdisabled = "link-dark pe-none";
                        else
                            classdisabled = "pe-auto";

                        if(val["url"] != undefined) {
                            $(".paginator").append('<a href="javascript:void(0);" data-url="'+val["url"]+'" class="page '+val["active"]+' mx-1 '+classdisabled+' text-decoration-none">'+val["label"]+'</a>');    
                            addEventPage(); 
                        }
                                           
                    });  

                    if(data["data"].length <= 0)
                        $(".204").removeClass("d-none");
                },
                error: function(data) {       
                    if(data.status == 401)
                        $(".401").append(data.responseJSON.error);
                        $(".401").removeClass("d-none");
                }
            });
        }

        addEventAjax(url);

        function addEventPage(){
            $(".page").unbind();
            $(".page").click(function(event) {
                if(!$(this).hasClass("true")) {
                    $(".lista").html("");
                    $(".paginator").html("");
                    addEventAjax($(this).data("url"));
                }                
            });
        }
    </script>
@endsection
