
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;


import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


import './common/successNotification.js';
import './common/errorNotification.js';
import './functions.js';
import './front/swiperSlider.js';
import './darkMode.js';

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import.meta.glob(['../assets/images/**']);




