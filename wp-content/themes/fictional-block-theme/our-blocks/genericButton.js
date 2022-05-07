import { link } from "@wordpress/icons"
import { ToolbarGroup, ToolbarButton } from "@wordpress/components"
import { RichText, BlockControls } from "@wordpress/block-editor"

wp.blocks.registerBlockType("ourblocktheme/genericbutton", {
  title: "Generic Button",
  attributes: {
    text: {type: "string"},
    size: {type: "string", default: "large"}
  },
  edit: EditComponent,
  save: SaveComponent
})

function EditComponent(props) {
  function handleTextChange(x) {
    props.setAttributes({text: x})
  }

  function buttonHandler() {
    s
  }

  return (
    <>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton onClick={buttonHandler} icon={link} />
        </ToolbarGroup>
        <ToolbarGroup>
          <ToolbarButton isPressed={props.attributes.size === "large"} onClick={() => props.setAttributes({size: "large"})}>Large</ToolbarButton>
          <ToolbarButton isPressed={props.attributes.size === "medium"} onClick={() => props.setAttributes({size: "medium"})}>Medium</ToolbarButton>
          <ToolbarButton isPressed={props.attributes.size === "small"} onClick={() => props.setAttributes({size: "small"})}>Small</ToolbarButton>
        </ToolbarGroup>
      </BlockControls>
      <RichText allowedFormats={[]} tagName="a" className={`btn btn--${props.attributes.size} btn--blue`} value={props.attributes.text} onChange={handleTextChange} />
    </>
  )
}

function SaveComponent(props) {
  return (
    <a href="#" value={props.attributes.size} className={`btn btn--${props.attributes.size} btn--blue`} value={props.attributes.text}>
      {props.attributes.text}
    </a>
  )
}