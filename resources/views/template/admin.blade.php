<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', session('parametros')[95]['VALOR'])</title>

    {!!Html::style('css/bootstrap.css')!!} 
    {!!Html::style('css/jquery-ui.css')!!}
    {!!Html::style('css/themes/default/style.css')!!}
    {!!Html::style('css/jquery.dataTables.min.css')!!}

    {!!Html::script('js/jquery.js')!!}
    {!!Html::script('js/jquery-ui.js')!!}
    {!!Html::script('js/jstree.js')!!}
    {!!Html::script('js/franz.js')!!}
    {!!Html::script('js/bootstrap.js')!!}
    {!!Html::script('js/jquery.dataTables.min.js')!!}
    {!!Html::script('js/validar.js')!!}

<style>
    .ocultar{
      display: none;
    }

    .footer{
        position: fixed;
        width: 100%;
        height: 40px;
        bottom: 0;        
    }

    /*.centrar{
      position: relative; 
      top: 50%;
      -ms-transform: translateY(-50%);
      -webkit-transform: translateY(-50%);
      transform: translateY(-50%);
    }*/

    .centro{
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>       

</head>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">{{session('parametros')[94]['VALOR']}}</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">Administracion</a></li>-->
        @if (Session::has('usuario'))
          @foreach (session('menus') as $menu)
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{$menu->menu->NOMBRE}}<span class="caret"></span></a>
            <ul class="dropdown-menu">
              @foreach ($menu->items as $item)
                <li>{!!link_to_route($item->URL, $title = $item->NOMBRE)!!}</li>
              @endforeach
            </ul>
          </li>
          @endforeach
        @endif
        <!--<li><a href="#">Page 1</a></li> -->       
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @if (Session::has('usuario'))

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="glyphicon glyphicon-user"></span>
            {{ session('usuario')->NOMBRE }}<span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li>{!!link_to_action('UsuarioController@cargarCambiarContrasena', $title = 'Cambiar Contraseña', $parameters = session('usuario')->ID, $attributes = ['class'=>'btn'])!!}</li>            
          </ul>
        </li>


        <li><a href="{!!URL::to('/logout')!!}"><span class="glyphicon glyphicon-log-out"></span><strong>{{session('parametros')[98]['VALOR']}}</strong></a></li>

        @endif
      </ul>

    </div>
    </div>
</nav>

<div class="container">  
  @section('panel')
    <div class="panel panel-primary">
      <div class="panel-heading">
          <h3 class="panel-title">@yield('panel-title')</h3>
      </div>
      <div class="panel-body">
          @yield('content')
      </div>
    </div>
  @show
</div>

<br><br>
<div class="footer bg-primary" style="font-size: 16px;" align="center">
    <p class="centro">{{session('parametros')[97]['VALOR']}}</p>
</div>

</body>

</html>
