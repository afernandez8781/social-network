<template>
	<div>
		<div @click="redirectIfGuest" class="card border-0 mb-3 shadow-sm" v-for="status in statuses">
			<div class="card-body d-flex flex-column">
				<div class="d-flex align-items-center mb-3">
					<img class="rounded-circle mr-3 shadow-sm" width="40px" src="https://avatars0.githubusercontent.com/u/33205904?s=400&u=388b4a2754a037d598d2bec4e42a7da102427768&v=4">
					<div>
						<h5 class="mb-1" v-text="status.user_name"></h5>
						<div class="small text-muted" v-text="status.ago"></div>
					</div>
				</div>
				<p class="card-text text-secondary" v-text="status.body"></p>
			</div>
			<div class="card-footer p-2">
				
				<button v-if="status.is_liked" 
						@click="unlike(status)"
						 class="btn btn-link btn-sm" 
						dusk="unlike-btn" 
				><strong>
					<i class="fa fa-thumbs-up text-primary mr-1"></i>
					TE GUSTA
				</strong></button>

				<button v-else
						@click="like(status)"
						class="btn btn-link btn-sm" 
						dusk="like-btn"
				>
					<i class="far fa-thumbs-up text-primary mr-1"></i>
					ME GUSTA
				</button>

			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				statuses: []
			}
		},
		mounted() {
			axios.get('/statuses')
				.then(res => {
					this.statuses = res.data.data
				})
				.catch(err => {
					console.log(err.response.data);
				});
			EventBus.$on('status-created', status => {
				this.statuses.unshift(status);
			})
		},
		methods: {
			like(status){

				axios.post(`/statuses/${status.id}/likes`)
					.then(res => {
						status.is_liked = true;
					})
			},
			unlike(status){
				axios.delete(`/statuses/${status.id}/likes`)
					.then(res => {
						status.is_liked = false;
					})
			}
		}
	}
</script>

<style scoped>
	
</style>