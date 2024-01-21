import React, { useEffect, useState } from 'react';

// Define a interface para o tipo de dados da resposta da API
interface AuthData {
  autenticado: boolean;
  nomeusuario: string;
  nivel: string;
  idServidorUsuario: string;
  idUsuario: string;
  token: string;
}

const App: React.FC = () => {
  const [authData, setAuthData] = useState<AuthData | null>(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch('https://www.siupa.com.br/conexao/api_login.php');
        const data = await response.json();
        console.log(data);
        // Define o tipo da resposta conforme a interface AuthData
       setAuthData(data as AuthData);

        // Se não autenticado, redirecione para "/"
        if (data && !data.autenticado) {
         //window.location.href = "/";
          console.log(data);
          var retrievedValue = sessionStorage.getItem('token');
          console.log(retrievedValue); // Output: 'value'
        }
      } catch (error) {
        console.error('Erro ao buscar dados da API:', error);
      }
    };

    fetchData();
  }, []);

  // Renderização condicional com base na resposta da API
  if (!authData) {
    return <p>Carregando...</p>;
  }

  return (
    <div>
      {authData.autenticado ? (
        <div>
          <p>Bem-vindo, {authData.nomeusuario}!</p>
          <p>Nível: {authData.nivel}</p>
          <p>ID do Servidor do Usuário: {authData.idServidorUsuario}</p>
          <p>ID do Usuário: {authData.idUsuario}</p>
          <p>ID do Usuário: {authData.token}</p>
        </div>
      ) : (
        <p>Redirecionando...</p>
      )}
    </div>
  );
};

export default App;
