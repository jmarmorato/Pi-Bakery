<?php

class Pi
{
	public static function get_pis($num_return = 10, $offset = 0)
	{
		try {
			$db = new Database();
			$db->connect();

			$sql = <<<'SQL'
			SELECT * FROM pis
			ORDER BY id DESC
			LIMIT :num_return OFFSET :start_offset;
	SQL;

			$statement = $db->db->prepare($sql);
			$statement->bindParam(":num_return", $num_return, PDO::PARAM_INT);
			$statement->bindParam(":start_offset", $offset, PDO::PARAM_INT);

			$statement->execute();
			$result = $statement->fetchall(PDO::FETCH_ASSOC);
			$statement->closeCursor();

			for ($i = 0; $i<count($result); $i++) {
				//Get the status of the pi
				if (file_exists("/var/www/PiBakery/writable/provision/" . $result[$i]["serial"])) {
					$result[$i]["status"] = "Provisioning";
				}
			}

			return $result;
		} catch (PDOException $e) {
			echo "Unrecoverable Database Error";
			echo $e;
			return false;
		}
	
	}

	public static function get_pi($pi_id)
	{
		try {
			$db = new Database();
			$db->connect();

			$sql = "SELECT * FROM pis WHERE id=:id;";

			$statement = $db->db->prepare($sql);
			$statement->bindParam(":id", $pi_id, PDO::PARAM_INT);

			$statement->execute();
			$result = $statement->fetchall(PDO::FETCH_ASSOC);
			$statement->closeCursor();
			return $result;
		} catch (PDOException $e) {
			echo "Unrecoverable Database Error";
			echo $e;
			return false;
		}
	
	}

	public static function get_template_parameters($serial) {
		try {
			$db = new Database();
			$db->connect();

			$sql = "SELECT * FROM template_parameters WHERE serial=:serial;";

			$statement = $db->db->prepare($sql);
			$statement->bindParam(":serial", $serial);

			$statement->execute();
			$result = $statement->fetchall(PDO::FETCH_ASSOC);
			$statement->closeCursor();

			return $result;
		} catch (PDOException $e) {
			echo "Unrecoverable Database Error";
			echo $e;
			return false;
		}
	}

	public static function new($name, $serial, $template, $image, $boot_net_type, $boot_net_ip, $boot_net_gateway, $os_net_type, $os_net_ip, $os_net_gateway, $templateParams)
	{
		try {
			$db = new Database();
			$db->connect();

			$sql = <<<'SQL'
			INSERT INTO pis (name, serial, template, image, boot_net_type, boot_net_ip, boot_net_gateway, main_net_type, main_net_ip, main_net_gateway, token)
			VALUES (:name, :serial, :template, :image, :boot_net_type, :boot_net_ip, :boot_net_gateway, :main_net_type, :main_net_ip, :main_net_gateway, :token);
	SQL;

			$r = rand();
			$token = hash("sha256", $r);

			$statement = $db->db->prepare($sql);
			$statement->bindParam(":name", $name);
			$statement->bindParam(":serial", $serial);
			$statement->bindParam(":template", $template);
			$statement->bindParam(":image", $image);
			$statement->bindParam(":boot_net_type", $boot_net_type);
			$statement->bindParam(":boot_net_ip", $boot_net_ip);
			$statement->bindParam(":boot_net_gateway", $boot_net_gateway);
			$statement->bindParam(":main_net_type", $os_net_type);
			$statement->bindParam(":main_net_ip", $os_net_ip);
			$statement->bindParam(":main_net_gateway", $os_net_gateway);
			$statement->bindParam(":token", $token);
			$statement->execute();

			$id = $db->db->lastInsertId();

			$templateParams = json_decode($templateParams);

			$sql = <<<'SQL'
			INSERT INTO template_parameters (serial, p_key, p_value)
			VALUES (:serial, :p_key, :p_value);
		SQL;

			$statement = $db->db->prepare($sql);


			foreach ($templateParams as $param) {
				$statement = $db->db->prepare($sql);
				$statement->bindParam(":serial", $serial);
				$statement->bindParam(":p_key", $param->key);
				$statement->bindParam(":p_value", $param->value);
				$statement->execute();
			}

			$statement->closeCursor();
			return $id;
		} catch (PDOException $e) {
			echo "Unrecoverable Database Error";
			echo $e;
			return false;
		}
	
	}

	public static function delete($piId)
	{
		try {
			$db = new Database();
			$db->connect();

			$sql = "SELECT serial FROM pis WHERE id=:id;";
			$statement = $db->db->prepare($sql);
			$statement->bindParam(":id", $piId, PDO::PARAM_INT);
			$statement->execute();
			$serial_result = $statement->fetch();

			var_dump($serial_result);

			$sql = "DELETE FROM template_parameters WHERE serial=:serial;";
			$statement = $db->db->prepare($sql);
			$statement->bindParam(":serial", $serial_result["serial"]);
			$statement->execute();

			$sql = <<<'SQL'
			DELETE FROM pis
			WHERE id=:piId;
	SQL;

			$statement = $db->db->prepare($sql);
			$statement->bindParam(":piId", $piId, PDO::PARAM_INT);

			$statement->execute();
			$statement->closeCursor();
			return true;
		} catch (PDOException $e) {
			echo "Unrecoverable Database Error";
			echo $e;
			return false;
		}
	
	}
}