import {
  createContext,
  Fragment,
  useCallback,
  useContext,
  useEffect,
  useState
} from 'react';
import { cancelToken, http } from '../utils/http';
import Spinner from '../components/common/sprinner';
import { Inertia } from '@inertiajs/inertia';
import authService from '../services/auth';

const AuthContext = createContext();

function AuthProvider(props) {
  const [user, setUser] = useState(null);

  const initialPage = useCallback(async () => {
    await http.get('/token/csrf');
  }, []);

  const fetchProfile = useCallback(() => {
    initialPage().then(() => {
      http
        .get('/profile', {
          cancelToken: cancelToken.token
        })
        .then((response) => {
          setUser(response.data);
        })
        .catch(() => {
          authService.logout().then(() => {
            Inertia.visit('/auth/login', {
              replace: true
            });
          });
        });
    });
  }, [setUser, initialPage]);

  useEffect(() => {
    fetchProfile();
  }, [fetchProfile]);

  if (user === null) {
    return <Spinner />;
  }

  return (
    <Fragment>
      <AuthContext.Provider
        value={{
          user
        }}
        {...props}
      />
    </Fragment>
  );
}

const useAuth = () => useContext(AuthContext);

export { AuthProvider, useAuth };
