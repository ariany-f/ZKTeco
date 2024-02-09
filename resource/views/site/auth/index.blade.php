@extends('templates.site')

@section('title', 'Login')
@section('url', route('site.login'))
@section('description', 'Faça login  em sua conta')

@section('container')
<section class="container login">
	<div class="row">
		<div class="col-md-12">
			<form action="{{ route('site.login.validate') }}" method="POST" class="form">
				@include('includes.messages')

				<h2 class="title">Faça seu login:</h2><hr />

				@include('includes.components.form.input', [
					'title' => 'E-Mail',
					'name' => 'email',
					'type' => 'email'
				])

				@include('includes.components.form.input', [
					'title' => 'Senha',
					'name' => 'password',
					'type' => 'password'
				])
				<div class="row">
					<div class="col-md-6">
						<p><a href="{{ route('site.account.pj.create') }}" title="Pessoa Jurídica">Criar Conta</a></p>
					</div>
					<div class="col-md-6" style="text-align: right;">
						<p><a href="{{ route('site.forget') }}" title="Recuperar senha">Esqueci minha senha</a></p>
					</div>
				</div>
				<input type="submit" class="primary-btn cta-btn" value="Entrar">

				<!-- <hr /> -->
				<!-- <div class="login-types">
					<a href="{{ route('site.login.facebook') }}" title="Logar com o Facebook" class="btn-primary"><i class="fa fa-facebook-f"></i> Login social com o Facebook</a>
					<a href="{{ route('site.login.google') }}" title="Logar com o Google" class="btn-danger"><i class="fa fa-google"></i> Login social com o Google</a>
				</div> -->
				
			</form>
		</div>
	</div>
</section>
@endsection