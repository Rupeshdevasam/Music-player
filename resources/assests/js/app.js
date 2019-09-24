import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './routes';

Vue.use(VueRouter); 

var v=new Vue({
	

	data:{
		count:0,
	},
	/**
	 * Binded Element(ID) 
	 * @type {String}
	 */
	el:'#root',
	router,
	
});
