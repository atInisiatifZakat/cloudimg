import {
  FormControl,
  FormErrorMessage,
  FormLabel,
  Grid,
  GridItem,
  Input
} from '@chakra-ui/react';
import { useFormik } from 'formik';

export default function CreateFrom() {
  const formik = useFormik({
    initialValues: {
      name: ''
    }
  });
  return (
    <Grid w="full">
      <GridItem>
        <FormControl id="email" isInvalid={Boolean(formik.errors.name)}>
          <FormLabel>Name</FormLabel>
          <Input
            isInvalid={Boolean(formik.errors.name)}
            errorBorderColor="red.200"
            placeholder="Name of source here..."
            name="text"
            type="name"
            value={formik.values.name}
            onChange={formik.handleChange}
          />
          <FormErrorMessage>{formik.errors.name}</FormErrorMessage>
        </FormControl>
      </GridItem>
    </Grid>
  );
}
