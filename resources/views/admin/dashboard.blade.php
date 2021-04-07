@extends('layouts.admin-app') 
@section('content')

<ul class="breadcrumb">
  <li>
    <i class="icon-home"></i>
    <a href="index.html">Home</a>
    <i class="icon-angle-right"></i>
  </li>
  <li><a href="#">Dashboard</a></li>
</ul>
<div class="row-fluid">
	<h2 class="stitle">Dashboard</h2>
	<h3 class="wtitle">Welcome to Star Auto Admin</h3>

	<div class="project-info">
		<div class="row">
			<div class="span4">
				<div class="project-board">
					<div class="board-icon">
						<img src="{{URL::to('images/01.png')}}" srcset="{{URL::to('images/01.png')}} 2x">  
					</div>
					<div class="board-text">
						<h2>ORDERS</h2>
						<h3>{{ isset($orders) ? count($orders):0 }}</h3>
					</div>				
				</div>
			</div>
			<div class="span4">
				<div class="project-board">
					<div class="board-icon">
						<img src="{{URL::to('images/02.png')}}"  srcset="{{URL::to('images/02.png')}} 2x">  
					</div>
					<div class="board-text">
						<h2>PRODUCTS</h2>
						<h3>{{ isset($products) ? count($products):0 }}</h3>
					</div>				
				</div>
			</div>
			<div class="span4">
				<div class="project-board">
					<div class="board-icon">
						<img src="{{URL::to('images/03.png')}}" srcset="{{URL::to('images/03.png')}} 2x">  
					</div>
					<div class="board-text">
						<h2>SERVICES</h2>
						<h3>{{ isset($services) ? count($services):0 }}</h3>
					</div>				
				</div>
			</div>
		</div>
	</div> 
</div>
@endsection
