@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
	
    <div class="container py-5">
        <h1 class="text-center mb-5">
            Lista de clientes
        </h1>

        <div class="401 alert alert-danger d-none" role="alert">
            
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Transactions</th>
                </tr>
            </thead>
            <tbody class="lista">
                
            </tbody>
        </table>

        <div class="paginator">

        </div>

        <h1 class="text-center mt-5">
            Buscador
        </h1>

        <label for="search-input" class="form-label">Digita nombres, emails o ID para buscar</label>
        <input type="search" class="form-control" id="search-input" placeholder="Type to search...">
        <div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
            <div class="toast-container position-absolute p-3 w-100">
                <div class="toast w-100" id="searchToastElement" data-bs-autohide="false" data-bs-animation="false" data-bs-delay="0">
                    <div class="toast-header">
                        <img src="#" class="rounded me-2" alt="">
                        <strong class="me-auto">Resultados</strong>
                        <small class="toast-search-count"></small>
                    </div>
                    <div class="toast-body">
                        
                    </div>
                </div>
            </div>
        </div>

        <h1 class="text-center mt-5 mb-5">
            LOGs
        </h1>

        <pre class="bg-dark text-light px-4">
            <code class="logs">
                
            </code>
        </pre>
    </div>

	<script type="text/javascript">
        var url = "{{ route('api-users', [$token]) }}";
        function addEventAjax(url){
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    $.each(data["data"], function(i, val) {
                        $(".lista").append('<tr><th scope="row">'+val["id"]+'</th><td>'+val["name"]+'</td><td>'+val["email"]+'</td><td>'+val["created_at"]+'</td><td><a href="'+val["transactions_client"]+'">Ver transacciones</a></td></tr>');
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

        $("#search-input").on("keyup", function() {
            if($(this).val() != '') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('api-search-users', [$token]) }}/"+$(this).val(),
                    success: function(data) {
                        $(".toast-body").html(""); 
                        $(".toast-search-count").html(data["data"].length); 
                        $.each(data["data"], function(i, val) {                                              
                            $(".toast-body").append('<div class="p-2"><a href="'+val["user_information"]+'" class="btn btn-light link-success text-decoration-none client"><b>* ID: </b><span>'+val["id"]+'</span>, <b>Name: </b><span>'+val["name"]+'</span>, <b>Email: </b><span>'+val["email"]+'</span></a></div>');
                        });
                        var searchToastElement = document.getElementById('searchToastElement');
                        var toast = new bootstrap.Toast(searchToastElement)
                        toast.show()
                    }
                });
            } else {
                var searchToastElement = document.getElementById('searchToastElement');
                var toast = new bootstrap.Toast(searchToastElement)
                toast.dispose()
            }         
        });

        $.ajax({
            type: "GET",
            url: "{{ route('api-log', [$token]) }}",
            success: function(data) {
                $(".logs").html();
                $.each(data["data"], function(i, val) {                                              
                    $(".logs").append("<p class='text-wrap'>Date: "+val["created_at"]+"  |  Token: "+val["token"]+"  |  Client_id: "+val["user_id"]+"  |  Ip: "+val["ip"]+"  |  Isp: "+val["isp"]+"  |  Location: "+val["location"]+"</p>");
                });
            }
        });
    </script>
@endsection
