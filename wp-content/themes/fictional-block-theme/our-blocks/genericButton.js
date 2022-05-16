import { link } from "@wordpress/icons"
import { ToolbarGroup, ToolbarButton , Popover, Button } from "@wordpress/components"
import { RichText, BlockControls, __experimentalLinkControl as LinkControl } from "@wordpress/block-editor"
import { useState } from "@wordpress/element"

wp.blocks.registerBlockType("ourblocktheme/genericbutton", {
  title: "Generic Button",
  attributes: {
    text: {type: "string"},
    size: {type: "string", default: "large"},
    linkObject: {type: "object"}
  },
  edit: EditComponent,
  save: SaveComponent
})

function EditComponent(props) {
  const [isLinkPickerVisible, setIsLinkPickerVisible] = useState(false)

  function handleTextChange(x) {
    props.setAttributes({text: x})
  }

  function buttonHandler() {
    setIsLinkPickerVisible(previousValue => !previousValue)
  }

  function handleLinkChange(newLink) {
    props.setAttributes({linkObject: newLink})
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
      {isLinkPickerVisible && (
        <Popover position="middle center">
          <LinkControl settings={[]} value={props.attributes.linkObject} onChange={handleLinkChange} />
          <Button variant="primary" onClick={() => setIsLinkPickerVisible(false)} style={{display: "block", width: "100%"}}>Confirm Link</Button>
        </Popover>
      )}
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