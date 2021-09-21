import React from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';

import theme from './theme';
import { ChakraProvider } from '@chakra-ui/react';

createInertiaApp({
  resolve: (name) => import(`./pages/${name}`),
  setup({ el, App, props }) {
    render(
      <ChakraProvider theme={theme}>
        <App {...props} />
      </ChakraProvider>,
      el
    );
  }
});
