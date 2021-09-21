import {
  extendTheme,
  withDefaultColorScheme,
  withDefaultVariant
} from '@chakra-ui/react';

const theme = extendTheme(
  {
    colors: {
      main: {
        50: '#e6f1fe',
        100: '#b3d4fb',
        200: '#80b8f9',
        300: '#4d9bf7',
        400: '#1a7ef4',
        500: '#0070f3',
        600: '#0065db',
        700: '#005ac2',
        800: '#004eaa',
        900: '#004392'
      },
      danger: {
        100: '#ffe5d7',
        200: '#ffc5af',
        300: '#ff9d87',
        400: '#ff7869',
        500: '#ff3b38',
        600: '#db2835',
        700: '#b71c34',
        800: '#931131',
        900: '#7a0a2f'
      },
      warning: {
        100: '#fffcd3',
        200: '#fff8a9',
        300: '#fff37b',
        400: '#ffee5d',
        500: '#ffe628',
        600: '#dbc21d',
        700: '#dbc21d',
        800: '#937f0c',
        900: '#7a6707'
      },
      success: {
        100: '#e1fbd9',
        200: '#bef8b4',
        300: '#8fea8a',
        400: '#69d66d',
        500: '#3cbc4d',
        600: '#2ba146',
        700: '#1e873f',
        800: '#136d38',
        900: '#0b5a33'
      },
      info: {
        100: '#e1e8ff',
        200: '#c4d1ff',
        300: '#a7b8ff',
        400: '#91a5ff',
        500: '#6d85ff',
        600: '#4f64db',
        700: '#3647b7',
        800: '#222f93',
        900: '#141e7a'
      }
    }
  },
  withDefaultColorScheme({ colorScheme: 'main' }),
  withDefaultVariant({
    variant: 'outline',
    components: ['Button', 'IconButton']
  })
);

export default theme;
