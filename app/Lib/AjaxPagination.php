<?php

namespace App\Lib;

class AjaxPagination{
      
      private $totalRowsCount;
	  private $resultPerPage;
	  private $pageNumber;
	  private $last;
	  private $StartFrom;
      
        public function __construct($params){
	    $this->totalRowsCount = $params["totalRows"];
        $this->resultPerPage = $params["resultPerPage"];
        $this->pageNumber = $params["pageNumber"];
        
      }
     
      public function returnOffset(){
		    
		$this->last = ceil($this->totalRowsCount/$this->resultPerPage);
		
		          if($this->last < 1){
	                 $this->last = 1;
                    }
				  
				  if ($this->pageNumber < 1) { 
				       $this->pageNumber = 1; 
			        } else if ($this->pageNumber > $this->last) { 
				       $this->pageNumber = $this->last; 
                  }
          $this->StartFrom = ($this->pageNumber - 1) * $this->resultPerPage;
				   
	      return $this->StartFrom;	   

       }// END METHOD returnOffset
	  
        public function returnLast(){
                    
                return $this->last;

        }// END METHOD returnLast
	  	  

        public function returnPageNumberberOf(){
                    
            return "Page <b>$this->pageNumber</b> of <b>$this->last</b>";

        }// END METHOD returnPageNumberberOf
}
