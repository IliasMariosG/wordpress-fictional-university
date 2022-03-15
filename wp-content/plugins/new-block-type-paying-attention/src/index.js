wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  attributes: {
    skyColor: {type: "string"},
    grassColor: {type: "string"}
  },
  edit: function (props) {
    function updateSkyColor(event) {
      props.setAttributes({skyColor: event.target.value})
    }

    function updateGrassColor(event) {
      props.setAttributes({grassColor: event.target.value})
    }
  
    return (
      <article>
        <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor}/>
        <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={updateGrassColor}/>
      </article>
    )
  },
  save: function (props) {
    // with `null` we remove the responsibility of the output from JS to PHP
    return null
  }
})
