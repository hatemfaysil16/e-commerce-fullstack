import React, { Component, Fragment } from 'react'
import { Link } from 'react-router-dom';

class MegaMenuMobile extends Component {

     constructor(props){
          super();
           
     }
 
 

     MenuItemClick=(event)=>{
          event.target.classList.toggle("active");
          var panel = event.target.nextElementSibling;
          if(panel.style.maxHeight){
               panel.style.maxHeight = null;
          }else{
               panel.style.maxHeight= panel.scrollHeight+ "px"
          }

     }


     render() { 

          const CatList = this.props.data;

          const MyView = CatList.map((CatList,i)=>{
               return <div key={i.toString()}>
      <button onClick={this.MenuItemClick} className="accordion">
      <img className="accordionMenuIcon" src={CatList.category_image} />&nbsp; {CatList.category_name}
                        </button>
          <div className="panel">
      <ul>
          {
               (CatList.subcategory_name).map((SubList,i)=>{
                    return <li key={i.toString()}><Link to={"productsubcategory/"+CatList.category_name+"/"+SubList.subcategory_name } className="accordionItem" >{SubList.subcategory_name} </Link></li>

               })    
          }
          
      </ul>
         </div> 
             
               </div>



          });





          return (
              <div className="accordionMenuDiv">
                   <div className="accordionMenuDivInside">

               {MyView}
   
                   </div>

              </div>
          )
     }
}

export default MegaMenuMobile


// import React, { Component, Fragment } from 'react'
// import { Link } from 'react-router-dom';

// class MegaMenuMobile extends Component {

//      constructor(){
//           super();
//           this.MegaMenu = this.MegaMenu.bind(this);
//      }

//      componentDidMount(){
//           this.MegaMenu();
//      }



//      MegaMenu(){
//           var acc = document.getElementsByClassName("accordionMobile");
//           var accNum = acc.length;
//           var i;
//           for(i=0;i<accNum;i++){
//                acc[i].addEventListener("click",function (){
//                     this.classList.toggle("active");
//                     var panel = this.nextElementSibling;
//                     if(panel.style.maxHeight){
//                          panel.style.maxHeight = null;
//                     }else{
//                          panel.style.maxHeight= panel.scrollHeight+ "px"
//                     }
//                })
//           }
//      }


//      render() {
//           return (
//               <div className="accordionMenuDivMobile">
//                    <div className="accordionMenuDivInsideMobile">

//            <button className="accordionMobile">
//                  {/* <img className="accordionMenuIconMobile" src="https://image.flaticon.com/icons/png/128/739/739249.png" />&nbsp; Men's Clothing  */}
//                         </button>
// <div className="panelMobile">
//      <ul>
//           <li><a href="#" className="accordionItemMobile" > Mans Tshirt 1</a></li>
//           <li><a href="#" className="accordionItemMobile" > Mans Tshirt 2</a></li>
//      </ul>
// </div>





//                    </div>

//               </div>
//           )
//      }
// }

// export default MegaMenuMobile
