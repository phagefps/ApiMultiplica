@extends('layouts.app')

@section('title', 'Información de cliente y transacciones')

@section('content')
	
    <div class="container py-5">
        <h1 class="text-center mb-5">
            <a href="{{ route('users', [$token]) }}" class="text-decoration-none"><<a> Información de cliente
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
                </tr>
            </thead>
            <tbody class="lista">
                
            </tbody>
        </table>

        <h1 class="text-center mt-5 mb-5">
            Transacciones
        </h1>

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
            <tbody class="lista2">
                
            </tbody>            
        </table>
    </div>

	<script type="text/javascript">
        $.ajax({
            type: "GET",
            url: "{{ route('api-information-users', [$token, $client_id]) }}",
            success: function(data) {
                $(".lista").append('<tr><th scope="row">'+data["data"][0]["id"]+'</th><td>'+data["data"][0]["name"]+'</td><td>'+data["data"][0]["email"]+'</td><td>'+data["data"][0]["created_at"]+'</td></tr>');

                $.each(data["data"][0]["transactions"], function(i, val) {
                    var type = val["type"];
                    if(type == "withdraw")
                        var classtype = "table-danger";
                    else
                        var classtype = "table-success";

                    $(".lista2").append('<tr class="'+classtype+'"><th scope="row">'+(i+1)+'</th><td>$'+val["amount"]+'</td><td>'+val["type"]+'</td><td>'+val["message"]+'</td><td>'+val["created_at"]+'</td></tr>');
                });  

                if(data["data"][0]["transactions"].length <= 0)
                    $(".204").removeClass("d-none");
            },
            error: function(data) {       
                if(data.status == 401)
                    $(".401").append(data.responseJSON.error);
                    $(".401").removeClass("d-none");
            }
        });
    </script>
@endsection
