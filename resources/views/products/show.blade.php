@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3>
				{{ $product->title }} ({{ $product->stock }})
			</h3>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form method="POST" action="{{ route('products.purchases.store', ['title' => $product->title, 'id' => $product->identifier]) }}">
            	@csrf
            	<input type="hidden" name="title" value="{{$product->title}}">
            	<input type="hidden" name="id" value="{{$product->identifier}}">
				<button class="btn btn-success btn-md">
					Purchase
				</button>
            </form>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<img
					src="{{ $product->picture }}"
					class="card-img-top"/>
					<div class="card-body">
						<h5 class="card-title">{{ $product->title }}</h5>
						<p class="card-text">{{ $product->details }}</p>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
