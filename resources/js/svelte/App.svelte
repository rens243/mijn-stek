<script>
	import Tailwindcss from './Tailwindcss.svelte'

	import Router from 'svelte-spa-router'
	import routes from './routes.js'

	import {push, location} from 'svelte-spa-router'

	import OldButton from './components/OldButton.svelte'
	import OldWindowManager from './components/OldWindowManager.svelte'
</script>

<Tailwindcss />

<!-- Window area in here -->
<section class="fixed top-0 left-0 right-0 bottom-0">
	<OldWindowManager></OldWindowManager>
	<Router {routes}></Router>
</section>

<!-- bottom bar -->
<section class="fixed bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-gray-200 to-gray-100 z-50 font-mono border-2 border-ridge flex justify-center align-middle">
	<OldButton on:click="{() => push('/')}" class="{`flex px-2 justify-center items-center ${$location == '/' ? 'bg-gray-400' : ''}`}">
		Home
	</OldButton>
	<OldButton on:click="{() => push('/ervaring')}" class="{`flex px-2 ml-2 justify-center items-center ${$location == '/ervaring' ? 'bg-gray-400' : ''}`}">
		Ervaring en vaardigheden
	</OldButton>
	<!-- <OldButton on:click="{() => push('/projecten')}" class="{`flex px-2 ml-2 justify-center items-center ${$location == '/projecten' ? 'bg-gray-400' : ''}`}">
		Projecten
	</OldButton> -->
	<OldButton on:click="{() => push('/contact')}" class="{`flex px-2 ml-2 justify-center items-center ${$location == '/contact' ? 'bg-gray-400' : ''}`}">
		Contact
	</OldButton>
</section>

<style>
	:global(body) {
		overflow: hidden;
	}
</style>
