/*
 * Access .env file
 *
 * */
require('dotenv').config();

/*
* Globals
*
* */
global._ = require('lodash');
global.axios = require('axios');
global.appConfig = {
  url: {
    base: process.env.APP_URL,
    api: process.env.APP_URL + 'api',
    admin: process.env.APP_URL + process.env.APP_ADMIN_DIR,
  },
  version: process.env.APP_VERSION,
};

global.window.scrollTo = () => {};
