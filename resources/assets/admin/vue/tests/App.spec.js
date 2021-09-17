import { createLocalVue, mount } from '@vue/test-utils';
import i18n from '@/i18n';
import router from '@/router';
import store from '@/store/index';

/*
* Components
*
* */
import App from '@/App';
import Login from '@/views/Auth/Login';

let wrapper;
const localVue = createLocalVue();

beforeAll(() => {
  wrapper = mount(App, {
    localVue,
    router,
    store,
    i18n,
    mocks: {},
    stubs: {

      // No need this
      SVGLib: true,
    },
  });
});

afterAll(() => {
  wrapper.destroy();
});

describe('App', () => {
  /*
  * Check if the application is initialized without any crash
  *
  * */
  test('The app container should be rendered correctly', async () => {
    // Skip the verifying step
    await wrapper.setData({ verifying: false });

    expect(wrapper).toMatchSnapshot();
  });

  /*
  * Check if the unauthenticated layout rendered
  *
  * */
  test('The authentication component should be rendered correctly', () => {
    expect(wrapper.findAllComponents(Login)).toHaveLength(1);
  });
});
