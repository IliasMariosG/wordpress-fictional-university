import './index.scss'
import {useSelect} from '@wordpress/data'
import {useState, useEffect} from 'react'
import apiFetch from '@wordpress/api-fetch'

wp.blocks.registerBlockType('ourplugin/featured-professor', {
  title: "Professor Callout",
  description:  "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    professorFeaturedID: {type: "string"}
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const [thePreview, setThePreview] = useState("")
  useEffect(() => {
    if (props.attributes.professorFeaturedID) {
      updateTheMeta()
      async function go() {
      const response = await apiFetch({
        path: `/featuredProfessor/v1/getHTML?professorID=${props.attributes.professorFeaturedID}`,
        method: "GET"
      })
      setThePreview(response)
    }
    go()
    }
  }, [props.attributes.professorFeaturedID])

  // delete appropriate item from post_meta when deleting a featured professor on the editor screen
  useEffect(() => {
    return () => {
      updateTheMeta()
    }
  }, [])

  function updateTheMeta() {
    // select any and all block types on the edit screen
    const professorsForMeta = wp.data.select("core/block-editor").getBlocks()
      // filter through them just for the featured professor block types
      .filter(x => x.name == "ourplugin/featured-professor")
      // An array of professors ID numbers is what we are trying to get 
      .map(x => x.attributes.professorFeaturedID)
      // filter out instances of the same professor
      .filter((valueOfItemBeingLooped, currentIndexBeingLooped, array) => {
        return array.indexOf(valueOfItemBeingLooped) == currentIndexBeingLooped;
      })
      console.log(professorsForMeta)

    wp.data.dispatch("core/editor").editPost({meta:{featuredProfessor: professorsForMeta}})
  }
  const allProfessors = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", {per_page: -1})
  })

  // It only shows for a split second
  if (allProfessors == undefined) return <p>Loading...</p>

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
       <select onChange={e => props.setAttributes({professorFeaturedID: e.target.value})}>
         <option>Select a professor.</option>
         {allProfessors.map(professor => {
           return (
             <option value={professor.id} selected={props.attributes.professorFeaturedID == professor.id}>
               {professor.title.rendered}
             </option>
           )
         })}
       </select>
      </div>
      <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
    </div>
  )
}