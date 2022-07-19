<?php
    /**
     * ---------------
     * Sala (Classe pai abstrata):
     * ---------------
     * Capacidade: int
     * Nome: String
     * ID: int
     * ---------------
     * __toString(): String
     * Limpeza()
     * ---------------
     * 
     * ^
     * |
     * 
     * -----------------------
     * Laboratorio (Classe filha):
     * -----------------------
     * Nº de Computadores: int
     * -----------------------
     * __toString(): String
     * .
     * .
     * .
     * -----------------------
     * 
     * |
     * V
     * 
     * --------
     * Reserva (Associativa):
     * --------
     * ID: int
     * IDLaboratorio: int
     * IDServidor: int
     * Data: Date
     * HoraInicio: Time
     * HoraFim: Time
     * --------
     * reservaLaboratorio()
     * verificaDisponibilidade()
     * --------
     * 
     * ^
     * |
     * 
     * ----------
     * Servidor:
     * ----------
     * Siape: int
     * Nome: String
     * ID: int
     * ----------
     * .
     * .
     * .
     * ----------
     * 
     */


    /**
     * Sobrescrita
     * 
     * Ambas possuem o método __toString. Porém, são diferentes (sobrescrita de "Laboratorio" em "Sala").
     */

    abstract class Sala{
        public function __toString(){
            return $this->getNome();
        }
        public abstract function limpeza();
    }



    class Laboratorio extends Sala{
        public function __toString(){
            return $this->getId();
        }
        public function limpeza(){

        }
    }
    
    class Reserva extends Geral{
        public function __construct($id, $idLaboratorio, $idServidor, $data, $hrInicio, $hrFim){
            if(self::verificaDisponibilidade($idLaboratorio, $data, $hrInicio, $hrFim)){
                $this->setId($id);
                $this->setIdLaboratorio($idLaboratorio);
                $this->setIdServdior($idServidor);
                $this->setData($data);
                $this->setHrInicio($hrInicio);
                $this->setHrFim($hrFim);
            } else{
                throw new Exception("Horário não disponível.");
            }
        }
        public static function verificaDisponibilidade($lab, $dt, $hri, $hrf){
            // Montar consulta
            $sql = "SELECT id FROM reserva
                    WHERE idLab = :idl
                    AND data = :dt
                    AND (:hri <= hrf and :hrf > hri)";
            $par = array(":idl"=>$lab,
                        ":dt"=>$dt,
                        ":hri"=>$hri,
                        ":hrf"=>$hrf);
            // Executar e retornar o resultado
            $row = parent::buscar($sql, $par);
            // var_dump($row); die();
            return count($row) == 0;
        }
    }
?>