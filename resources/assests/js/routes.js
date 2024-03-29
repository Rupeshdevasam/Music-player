import VueRouter from 'vue-router';
import router from './routes';


let routes=[
{

	path:'/',

	component: require('./views/Home.vue').default

},
{

	path:"/create",

	component: require('./views/AddSong').default

},
{

	path:"/logout",

	component: require('./views/Logout').default

} 
];

export default new VueRouter({

	routes,

	'linkActiveClass':'is-active'

});