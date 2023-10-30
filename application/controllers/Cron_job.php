<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends Telescoope_Controller {

	public function sinkron_vendor($vnd_id="")
	{	
        $this->load->model("Sinkron_m");
        $startTime = microtime(true);
   
		$login_status = $this->Sinkron_m->do_sinkron($vnd_id);	

		echo $login_status;
		$this->m_log($login_status, 'log_cronjob');
		$endTime = microtime(true);
	    $diff = $endTime - $startTime;
	    $minutes = $diff / 60; //only minutes
	    $seconds = $diff % 60;//remaining seconds, using modulo operator

	  	// echo "execution time : ".$seconds.' seconds';

	}

	//define function name  
	function m_log($arMsg,$filename="")  
	{  
		//define empty string                                 
		$stEntry="";  
		//get the event occur date time,when it will happened  
		$arLogData['event_datetime']='['.date('D Y-m-d h:i:s A').'] [client '.$_SERVER['REMOTE_ADDR'].']';  
		//if message is array type  
		if(is_array($arMsg))  
		{  
			//concatenate msg with datetime  
			foreach($arMsg as $msg)  
			$stEntry.=$arLogData['event_datetime']." ".$msg."\r \n";  
		}  
		else  
		{   //concatenate msg with datetime  
			
			$stEntry.=$arLogData['event_datetime']." ".$arMsg."\r \n";  
		}  
		//create file with current date name  
		if (!empty($filename)) {
			$stCurLogFileName= $filename.'.txt'; 
		}else{
			$stCurLogFileName='log_'.date('D Y-m-d h:i:s A').'.txt';  
		}
		
		//open the file append mode,dats the log file will create day wise  
		$fHandler=fopen(APPPATH.'logs/'.$stCurLogFileName,'a+');  
		//write the info into the file  
		fwrite($fHandler,$stEntry);  
		//close handler  
		fclose($fHandler);  
	}  

}

/* End of file Cron_job.php */
/* Location: ./application/controllers/Cron_job.php */