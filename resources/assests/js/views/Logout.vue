<template>


</template>

<script>
	export default{
			mounted()
			{
				axios.post('/logout').then(response => {

					alert("LoggedOut");
					window.location="/#/create";
					});
			}
	};
</script>