import { Inertia } from '@inertiajs/inertia';
import {
  Button,
  Flex,
  FormControl,
  FormErrorMessage,
  Input,
  VStack
} from '@chakra-ui/react';

import authService from '../../services/auth';

import * as yup from 'yup';

import { useFormik } from 'formik';

const validationSchema = yup.object().shape({
  email: yup
    .string()
    .email('Invalid email format')
    .required('This field is required'),
  password: yup.string().required('This field is required')
});

export default function Login() {
  const formik = useFormik({
    validationSchema: validationSchema,
    initialValues: {
      email: '',
      password: ''
    },
    onSubmit: (data, formikHelper) => {
      authService
        .login(data.email, data.password)
        .then(() => {
          Inertia.visit('/home');
        })
        .catch((error) => {
          if (error.status === 400) {
            formikHelper.setFieldError('email', error.data.message);
          } else if (error.status === 422) {
            for (const property in error.data.errors) {
              formikHelper.setFieldError(
                property,
                error.data.errors[property][0]
              );
            }
          } else {
            throw error;
          }
        });
    }
  });

  return (
    <Flex minH="100vh" justifyContent="center" alignItems="center">
      <Flex
        direction="column"
        minW="lg"
        rounded="md"
        shadow="md"
        minH="72"
        justifyContent="center"
      >
        <form onSubmit={formik.handleSubmit}>
          <VStack spacing={6} padding={8}>
            <FormControl id="email" isInvalid={Boolean(formik.errors.email)}>
              <Input
                isInvalid={Boolean(formik.errors.email)}
                errorBorderColor="red.200"
                placeholder="your@email.com"
                name="email"
                type="email"
                variant="filled"
                value={formik.values.email}
                onChange={formik.handleChange}
              />
              <FormErrorMessage>{formik.errors.email}</FormErrorMessage>
            </FormControl>
            <FormControl id="email" isInvalid={Boolean(formik.errors.password)}>
              <Input
                isInvalid={Boolean(formik.errors.password)}
                errorBorderColor="red.200"
                placeholder="**********"
                name="password"
                type="password"
                variant="filled"
                value={formik.values.password}
                onChange={formik.handleChange}
              />
              <FormErrorMessage>{formik.errors.password}</FormErrorMessage>
            </FormControl>
            <Button isFullWidth type="submit" variant="solid">
              Login
            </Button>
          </VStack>
        </form>
      </Flex>
    </Flex>
  );
}
