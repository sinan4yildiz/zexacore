import { createLocalVue, mount } from '@vue/test-utils';
import App from '@/App';
import i18n from '@/i18n';
import router from '@/router';
import store from '@/store/index';

let wrapper;
const localVue = createLocalVue();

beforeAll(() => {
  wrapper = mount(App, {
    localVue,
    router,
    store,
    i18n,
  });
});

afterAll(() => {
  wrapper.destroy();
});

describe('App', () => {
  /*
  * Check if the application is initialized correctly
  *
  * */
  test('The app container should be rendered correctly', () => {
    expect(wrapper).toMatchSnapshot();
  });

  /*
  * More testing units will be here
  *
  * */
});
