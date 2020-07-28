<?php


class LocaisDAO {
    private $connection = null;

    public function insert($dados)
    {
        require_once('./dao/class.connection.php');
        $this->connection = null;
        $retorno = array();

        $this->connection = new ConnectionFactory();
        $this->connection->beginTransaction();
        try{
            $query = "INSERT INTO locais 
                      (nome, cep, logradouro, complemento, numero, bairro, uf, cidade, data) 
                      VALUES 
                      (:nome, :cep, :logradouro, :complemento, :numero, :bairro, :uf, :cidade, :data)";


            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":nome", $dados['nome'], PDO::PARAM_STR);
            $stmt->bindValue(":cep", $dados['cep'], PDO::PARAM_STR);
            $stmt->bindValue(":logradouro", $dados['logradouro'], PDO::PARAM_STR);
            $stmt->bindValue(":complemento", $dados['complemento'], PDO::PARAM_STR);
            $stmt->bindValue(":numero", $dados['numero'], PDO::PARAM_STR);
            $stmt->bindValue(":bairro", $dados['bairro'], PDO::PARAM_STR);
            $stmt->bindValue(":uf", $dados['uf'], PDO::PARAM_STR);
            $stmt->bindValue(":cidade", $dados['cidade'], PDO::PARAM_STR);
            $stmt->bindValue(":data", $dados['data'], PDO::PARAM_STR);
            $stmt->execute();
            $errors = $stmt->errorInfo();
            if( $errors[2] == '' ){
                $this->connection->commit();
                $retorno = array(
                    'msg'    => 'Dados salvos com sucesso!',
                    'status' => true
                );

            }else{
                throw new Exception($errors[2]);
            }


            $this->connection =  null;
        }catch(PDOException $exception){
            $retorno = array(
                'msg'    => 'Houve um problema ao tentar salvar!',
                'log'    => $exception->getMessage(),
                'status' => false
            );            
        }
        return $retorno;

    }

    public function update($dados)
    {
        require_once('./dao/class.connection.php');
        $this->connection = null;
        $retorno = array();

        $this->connection = new ConnectionFactory();
        $this->connection->beginTransaction();
        try{
            $query = "UPDATE locais SET
                        nome = :nome, 
                        cep  = :cep,
                        logradouro = :logradouro,
                        complemento = :complemento, 
                        numero = :numero, 
                        bairro = :bairro, 
                        uf = :uf, 
                        cidade = :cidade, 
                        data = :data
                        WHERE id = :id
                      ";

          
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":nome", $dados['nome'], PDO::PARAM_STR);
            $stmt->bindValue(":cep", $dados['cep'], PDO::PARAM_STR);
            $stmt->bindValue(":logradouro", $dados['logradouro'], PDO::PARAM_STR);
            $stmt->bindValue(":complemento", $dados['complemento'], PDO::PARAM_STR);
            $stmt->bindValue(":numero", $dados['numero'], PDO::PARAM_STR);
            $stmt->bindValue(":bairro", $dados['bairro'], PDO::PARAM_STR);
            $stmt->bindValue(":uf", $dados['uf'], PDO::PARAM_STR);
            $stmt->bindValue(":cidade", $dados['cidade'], PDO::PARAM_STR);
            $stmt->bindValue(":data", $dados['data'], PDO::PARAM_STR);
            $stmt->bindValue(":id", $dados['id'], PDO::PARAM_INT);
            $stmt->execute();
            $errors = $stmt->errorInfo();
            if( $errors[2] == '' ){
                $this->connection->commit();
                $retorno = array(
                    'msg'    => 'Dados salvos com sucesso!',
                    'status' => true
                );

            }else{
                throw new Exception($errors[2]);
            }


            $this->connection =  null;
        }catch(PDOException $exception){
            $retorno = array(
                'msg'    => 'Houve um problema ao tentar salvar!',
                'log'    => $exception->getMessage(),
                'status' => false
            );            
        }
        return $retorno;
    }

    public function delete($id)
    {
        require_once('./dao/class.connection.php');
        $this->connection = null;
        $retorno = array();

        $this->connection = new ConnectionFactory();
        $this->connection->beginTransaction();
        try{
            $query = "DELETE FROM locais WHERE id = :id";

          
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $errors = $stmt->errorInfo();
            if( $errors[2] == '' ){
                $this->connection->commit();
                $retorno = array(
                    'msg'    => 'Item removido com sucesso!',
                    'status' => true
                );

            }else{
                throw new Exception($errors[2]);
            }


            $this->connection =  null;
        }catch(PDOException $exception){
            $retorno = array(
                'msg'    => 'Houve um problema ao tentar salvar!',
                'log'    => $exception->getMessage(),
                'status' => false
            );            
        }
        return $retorno;

    }

    public function listaDeLocais(){
        require_once('./dao/class.connection.php');

        $this->connection = null;

        $this->connection = new ConnectionFactory();

        $retorno = array();

        try {

            $sql = "SELECT id
                           ,nome
                           ,uf
                           ,DATE_FORMAT( data, '%d/%m/%Y' ) data
                    FROM locais";
            $stmt = $this->connection->prepare($sql);

            $stmt->execute();
            $errors = $stmt->errorInfo();
            if( $errors[2] == '' ){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $retorno[] = array(
                        'id'  => $row['id'],
                        'uf'  => $row['uf'],
                        'nome'  => $row['nome'],
                        'data'  => $row['data']
                    );
                }
            }    
            else{
                throw new Exception($errors[2]);  
            }    
            $this->connection = null;
        } catch (PDOException $ex) {
            $retorno = array(
                'msg'    => 'Houve um problema ao tentar salvar!',
                'log'    => $exception->getMessage(),
                'status' => false
            );   
        }
        return $retorno;
    }


    public function getById($id){
        require_once('./dao/class.connection.php');

        $this->connection = null;

        $this->connection = new ConnectionFactory();

        $retorno = array();

        try {

            $sql = "SELECT *
                    FROM locais";
            $stmt = $this->connection->prepare($sql);

            $stmt->execute();
            $errors = $stmt->errorInfo();
            if( $errors[2] == '' ){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $retorno = array(
                        'id'           => $row['id'],
                        'uf'           => $row['uf'],
                        'nome'         => $row['nome'],
                        'data'         => $row['data'],
                        'cep'          => $row['cep'],
                        'logradouro'   => $row['logradouro'],
                        'complemento'  => $row['complemento'],
                        'bairro'        => $row['bairro'],
                        'numero'       => $row['numero'],
                        'cidade'       => $row['cidade'],
                        'uf'           => $row['uf']
                    );
                }
            }    
            else{
                throw new Exception($errors[2]);  
            }    
            $this->connection = null;
        } catch (PDOException $ex) {
            $retorno = array(
                'msg'    => 'Houve um problema ao tentar salvar!',
                'log'    => $exception->getMessage(),
                'status' => false
            );   
        }
        return $retorno;
    }

}

?>