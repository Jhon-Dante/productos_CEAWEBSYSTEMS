<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

        <script src="{{ asset('assets/js/jquery.js') }}"></script>

        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="title">
                            Productos
                        </div>
                        <button class="btn btn-primary mb-3" onclick="AggProduct()">Agregar</button>
                        <table class="table" style="display: none;" id="showAggProduct">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="add_product" placeholder="Nombre del producto" name="name">
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="add_price" placeholder="precio del producto" name="price">
                                </td>
                                <td>
                                    <button class="btn btn-success" onclick="AddProduct()">Agregar</button>
                                </td>
                            </tr>
                        </table>

                        <table class="table" style="display: none;" id="showEditProduct">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" id="edit_product" placeholder="Nombre del producto" name="name">
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="edit_price" placeholder="precio del producto" name="price">
                                </td>
                                <td>
                                    <input type="hidden" name="id" id="id_product">
                                    <button class="btn btn-warning" onclick="updateProduct()">Editar</button>
                                </td>
                            </tr>
                        </table>


                        <div id="productos"></div>
                        <div id="app"></div>
                        
                    </div>
                </div>
        </div>

        <div class="modal fade" id="AddComentary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Comentario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="commentary" id="add_commentary" class="form-control" placeholder="Nuevo Comentario">
              </div>
              <div class="modal-footer">
                <input type="hidden" name="id_product" id="id_product_comment">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="AddComentary()">Guardar Comentario</button>
              </div>
            </div>
          </div>
        </div>
    </body>


    <script type="text/javascript">

        $( document ).ready(function() {
            getProducts();
        });

        function getProducts() {
            $('#productos').empty();

            $.get("products/1/get",function (data) {
            })
            .done(function(data) {
                if(data.length>0){
                    $('#productos').append(
                        '<table class="table">'+
                            '<thead>'+
                                '<tr>'+
                                    '<td>Nombre</td>'+
                                    '<td>Precio</td>'+
                                    '<td>Comentarios</th>'+
                                    '<td>Acciones</td>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="showProducts">'+
                            '</tbody>'+
                        '<table>'
                    );

                    for (var i = 0; i < data.length; i++) {
                        var comments = "";

                        if (data[i].comments.length > 0) {
                            for (var j = 0; j < data[i].comments.length; j++) {
                                comments += '<li>'+data[i].comments[j].commentary+' <a style="color:red; text-decoration:none" href="#" onclick="deleteCommentary('+data[i].comments[j].id+')">X</a></li>';
                            }
                        }else{
                            var comments = 'Sin comentarios';
                        }

                        $('#showProducts').append('<tr><td>'+data[i].name+'</td><td>'+data[i].price+'$</td><td>'+comments+'<br><button class="btn bt-primary btn-sm" onclick="showAddComentary('+data[i].id+')">Add</button</td><td>'
                            +'<a style="text-decoration:none; color:green" href="#" onclick="editProduct('+data[i].id+')">editar</a><br>'
                            +'<a style="text-decoration:none; color:red" href="#" onclick="delete_product('+data[i].id+')">eliminar</a></td></tr>');
                    }
                }
            });
        }
        function AggProduct() {
            $('#showAggProduct').show();
            $('#showEditProduct').hide();
        }
        function AddProduct() {

            $('#add_product').removeClass('border border-danger');
            $('#add_price').removeClass('border border-danger');

            var product = $('#add_product').val();
            var price = $('#add_price').val();

            if (product == null || product == 0) {
                $('#add_product').addClass('border border-danger');
                return 0;
            }

            if (price == null || price == 0) {
                $('#add_price').addClass('border border-danger');
                return 0;
            }

            $.post('products/store',{
                name: product,
                price: price,
                _token: '{{csrf_token()}}'
            }
            ,function (data) {
            })
            .done(function(data) {
                getProducts();
            });
        }

        function editProduct(id,name,price) {

            $.get("products/"+id+"/show",function (data) {
            })
            .done(function(data) {
                $('#id_product').val(id);
                $('#edit_product').val(data.name);
                $('#edit_price').val(data.price);
            });

            $('#showAggProduct').hide();
            $('#showEditProduct').show();

        }

        function updateProduct() {
            $('#edit_product').removeClass('border border-danger');
            $('#edit_price').removeClass('border border-danger');

            var id = $('#id_product').val();
            var product = $('#edit_product').val();
            var price = $('#edit_price').val();

            if (product == null || product == 0) {
                $('#edit_product').addClass('border border-danger');
                return 0;
            }

            if (price == null || price == 0) {
                $('#edit_price').addClass('border border-danger');
                return 0;
            }

            $.post('products/update',{
                id: id,
                name: product,
                price: price,
                _token: '{{csrf_token()}}'
            }
            ,function (data) {
            })
            .done(function(data) {
                getProducts();
            });
        }

        function delete_product(id) {
            $.get("products/"+id+"/delete",function (data) {
            })
            .done(function(data) {
                getProducts();
            });
        }

        function showAddComentary(id_product) {
            $('#AddComentary').modal('show');
            $('#id_product_comment').val(id_product);

        }

        function AddComentary() {

            $('#add_commentary').removeClass('border border-danger');

            var commentary = $('#add_commentary').val();
            var product_id = $('#id_product_comment').val();

            if (commentary == null || commentary == 0) {
                $('#add_commentary').addClass('border border-danger');
                return 0;
            }

            $.post('comments/store',{
                commentary: commentary,
                product_id: product_id,
                _token: '{{csrf_token()}}'
            }
            ,function (data) {
            })
            .done(function(data) {
                getProducts();
            });
        }

        function deleteCommentary(id) {
            $.get("comments/"+id+"/delete",function (data) {
            })
            .done(function(data) {
                getProducts();
            });
        }
    </script>
</html>
