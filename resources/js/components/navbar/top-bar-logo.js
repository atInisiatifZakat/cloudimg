import { Link } from '@inertiajs/inertia-react';
import { chakra, Image, VisuallyHidden } from '@chakra-ui/react';
import Logo from '../../assets/images/logo.svg';

export default function TopBarLogo() {
  return (
    <chakra.a
      as={Link}
      href="/home"
      title="CloudImg"
      display="flex"
      alignItems="center"
    >
      <Image src={Logo} htmlWidth="40" />
      <VisuallyHidden>Ziswapp</VisuallyHidden>
    </chakra.a>
  );
}
